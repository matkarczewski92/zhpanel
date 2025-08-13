<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class FacebookService
{
    /** Wersja Graph API (domyślnie v19.0) */
    protected string $apiVersion;

    /** Bazowy endpoint Graph API */
    protected string $baseUrl;

    /** ID strony (Page ID), na którą publikujemy */
    protected string $pageId;

    /** APP ID i SECRET z .env (opcjonalnie dla appsecret_proof) */
    protected ?string $appId;
    protected ?string $appSecret;

    /** Token (finalny PAGE TOKEN) */
    protected string $accessToken;

    public function __construct()
    {
        $this->apiVersion = (string) env('FB_API_VERSION', 'v19.0');
        $this->baseUrl    = "https://graph.facebook.com/{$this->apiVersion}";
        $this->pageId     = (string) env('FB_PAGE_ID');
        $this->appId      = env('FB_APP_ID');
        $this->appSecret  = env('FB_APP_SECRET');

        if (!function_exists('systemConfig')) {
            throw new RuntimeException("Brak helpera systemConfig(). Nie mogę pobrać fbToken.");
        }

        $rawToken = (string) (systemConfig('fbToken') ?? '');
        if ($rawToken === '') {
            throw new RuntimeException("Brak fbToken w systemConfig('fbToken'). Wklej tam user/page token.");
        }

        $this->accessToken = $this->resolvePageToken($rawToken, $this->pageId);
    }

    /**
     * Zamienia USER TOKEN na PAGE TOKEN (jeśli trzeba).
     */
    protected function resolvePageToken(string $token, string $pageId): string
{
    // 1) Spróbuj wykryć typ tokena przez /debug_token
    try {
        $params = ['input_token' => $token];

        if ($this->appId && $this->appSecret) {
            // app access token jest najpewniejszy do debug_token
            $params['access_token'] = "{$this->appId}|{$this->appSecret}";
        } else {
            // fallback – mniej idealny, ale zadziała w Dev
            $params['access_token'] = $token;
        }

        $dbg = Http::get("{$this->baseUrl}/debug_token", $params);
        $info = $this->guard($dbg, 'debug_token');

        $type = strtoupper((string)($info['data']['type'] ?? ''));
        if ($type === 'PAGE') {
            // To już jest PAGE TOKEN – nic nie wymieniamy
            return $token;
        }
        // jeśli USER – polecimy dalej do /me/accounts
    } catch (\Throwable $e) {
        // Nie blokuj – jak debug się wysypie, spróbujmy /me/accounts.
        Log::warning('FB debug_token failed, trying /me/accounts: '.$e->getMessage());
    }

    // 2) W tym miejscu traktujemy token jako USER TOKEN → pobierz PAGE TOKEN
    $r = Http::get("{$this->baseUrl}/me/accounts", [
        'fields'       => 'id,name,access_token',
        'access_token' => $token,
    ]);

    // Jeśli tu wyleci (#100) "accounts on Page", to znaczy, że jednak był Page token
    if ($r->status() === 400 && str_contains($r->body(), 'accounts') && str_contains($r->body(), 'node type (Page)')) {
        return $token; // użyj go wprost
    }

    $data = $this->guard($r, 'me/accounts');

    $page = collect($data['data'] ?? [])->firstWhere('id', $pageId);
    if (!$page || empty($page['access_token'])) {
        throw new RuntimeException('Nie udało się uzyskać Page Access Tokenu. Upewnij się, że fbToken to USER TOKEN z uprawnieniami pages_* i że masz rolę na stronie.');
    }

    return $page['access_token'];
}


    /**
     * Dodaje appsecret_proof, jeśli mamy APP_SECRET.
     */
    protected function withSecurity(array $params): array
    {
        if ($this->appSecret && !empty($params['access_token'])) {
            $params['appsecret_proof'] = hash_hmac('sha256', $params['access_token'], $this->appSecret);
        }
        return $params;
    }

    /**
     * Wspólna walidacja odpowiedzi.
     */
    private function guard(Response $resp, string $context): array
    {
        if ($resp->failed()) {
            Log::error("FB API FAILED ({$context})", [
                'status' => $resp->status(),
                'body'   => $resp->body(),
            ]);
            throw new RuntimeException("Facebook API error ({$context}): " . $resp->body());
        }

        $data = $resp->json();

        if (isset($data['error'])) {
            Log::error("FB API ERROR FIELD ({$context})", ['error' => $data['error']]);
            throw new RuntimeException("Facebook API error ({$context}): " . json_encode($data['error']));
        }

        return $data;
    }

    /**
     * Post tekstowy.
     */
    public function postText(string $message): array
    {
        $payload = $this->withSecurity([
            'message'      => $message,
            'access_token' => $this->accessToken,
        ]);

        $resp = Http::asForm()->post("{$this->baseUrl}/{$this->pageId}/feed", $payload);
        return $this->guard($resp, 'postText');
    }

    /**
     * Post ze zdjęciem.
     */
    public function postImage(?string $message, string $url): array
    {
        $payload = $this->withSecurity([
            'url'          => $url,
            'caption'      => $message ?? '',
            'access_token' => $this->accessToken,
        ]);

        $resp = Http::asForm()->post("{$this->baseUrl}/{$this->pageId}/photos", $payload);
        return $this->guard($resp, 'postImage');
    }

    /**
     * Post z wieloma zdjęciami – próba unpublished + fallback na komentarze przy błędzie #3.
     */
    public function postMultipleImages(?string $message, array $urls): array
    {
        try {
            $attached = [];

            foreach ($urls as $url) {
                if (!is_string($url) || trim($url) === '') continue;

                $uploadPayload = $this->withSecurity([
                    'url'          => $url,
                    'published'    => false,
                    'access_token' => $this->accessToken,
                ]);

                $r = Http::asForm()->post("{$this->baseUrl}/{$this->pageId}/photos", $uploadPayload);
                $photo = $this->guard($r, 'uploadPhoto(unpublished)');

                if (!empty($photo['id'])) {
                    $attached[] = ['media_fbid' => $photo['id']];
                }
            }

            if (empty($attached)) {
                throw new RuntimeException('Brak zdjęć do opublikowania.');
            }

            $feedPayload = $this->withSecurity([
                'message'        => $message ?? '',
                'attached_media' => json_encode($attached),
                'access_token'   => $this->accessToken,
            ]);

            $resp = Http::asForm()->post("{$this->baseUrl}/{$this->pageId}/feed", $feedPayload);
            return $this->guard($resp, 'createFeedWithMedia');

        } catch (\Throwable $e) {
            $body = $e->getMessage();
            if (str_contains($body, 'code":3') || str_contains($body, 'capability')) {
                return $this->postWithCommentsFallback($message, $urls);
            }
            throw $e;
        }
    }

    /**
     * Fallback: pierwsze zdjęcie w poście, reszta w komentarzach.
     */
    protected function postWithCommentsFallback(?string $message, array $urls): array
    {
        if (empty($urls)) {
            return $this->postText($message ?? '');
        }

        // Główny post: pierwsze zdjęcie
        $first = array_shift($urls);
        $payload = $this->withSecurity([
            'url'          => $first,
            'caption'      => $message ?? '',
            'access_token' => $this->accessToken,
        ]);
        $r = Http::asForm()->post("{$this->baseUrl}/{$this->pageId}/photos", $payload);
        $post = $this->guard($r, 'fallback:firstPhoto');

        $postId = $post['post_id'] ?? null;
        if (!$postId) {
            throw new RuntimeException('Brak post_id po publikacji pierwszego zdjęcia (fallback).');
        }

        // Reszta zdjęć jako komentarze
        foreach ($urls as $url) {
            $commentPayload = $this->withSecurity([
                'attachment_url' => $url,
                'access_token'   => $this->accessToken,
            ]);
            $cr = Http::asForm()->post("{$this->baseUrl}/{$postId}/comments", $commentPayload);
            $this->guard($cr, 'fallback:commentPhoto');
        }

        return ['id' => $postId, 'fallback' => true];
    }
}
