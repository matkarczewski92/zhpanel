<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class FacebookService
{
    /** Wersja Graph API (z .env albo domyślnie v20.0) */
    protected string $apiVersion;

    /** Bazowy endpoint Graph API */
    protected string $baseUrl;

    /** ID strony (Page ID), na którą publikujemy */
    protected string $pageId;

    /** APP ID i SECRET z .env (do debugowania/appsecret_proof) */
    protected ?string $appId;
    protected ?string $appSecret;

    /** Token, którego użyjemy do wywołań publikujących (finalnie: PAGE TOKEN) */
    protected string $accessToken;

    public function __construct()
    {
        $this->apiVersion = (string) env('FB_API_VERSION', 'v20.0');
        $this->baseUrl    = "https://graph.facebook.com/{$this->apiVersion}";
        $this->pageId     = (string) env('FB_PAGE_ID');
        $this->appId      = env('FB_APP_ID');
        $this->appSecret  = env('FB_APP_SECRET');

        // WYMAGANIE: token tylko z systemConfig('fbToken')
        if (!function_exists('systemConfig')) {
            throw new RuntimeException("Brak helpera systemConfig(). Nie mogę pobrać fbToken.");
        }

        $rawToken = (string) (systemConfig('fbToken') ?? '');
        if ($rawToken === '') {
            throw new RuntimeException("Brak fbToken w systemConfig('fbToken'). Wklej tam user/page token.");
        }

        // Jeżeli to USER TOKEN, zamień na PAGE TOKEN dla FB_PAGE_ID
        $this->accessToken = $this->resolvePageToken($rawToken, $this->pageId);
    }

    /**
     * Jeśli podano USER TOKEN – pobierz PAGE TOKEN dla wskazanej strony.
     * Jeśli podano już PAGE TOKEN – zwróci go bez zmian (weryfikujemy po /debug_token).
     */
    protected function resolvePageToken(string $token, string $pageId): string
    {
        // Spróbujmy sprawdzić, do jakiej aplikacji/token jest i czy to page token:
        try {
            $debugParams = [
                'input_token' => $token,
            ];

            // Jeśli mamy APP_ID|APP_SECRET – użyjemy ich do debug_token (bezpieczniej i stabilniej)
            if ($this->appId && $this->appSecret) {
                $debugParams['access_token'] = "{$this->appId}|{$this->appSecret}";
            } else {
                // fallback – sam token (mniej idealne, ale zadziała do podstawowej walidacji)
                $debugParams['access_token'] = $token;
            }

            $debug = Http::get("{$this->baseUrl}/debug_token", $debugParams);
            $info  = $this->guard($debug, 'debug_token');

            $isPageToken = false;
            if (!empty($info['data']['type'])) {
                // Facebook zwraca czasem 'USER' / 'PAGE' w data.type – jeśli jest, użyj.
                $isPageToken = strtoupper((string)$info['data']['type']) === 'PAGE';
            }

            // Jeśli to PAGE TOKEN – zwracamy od razu
            if ($isPageToken) {
                return $token;
            }
        } catch (\Throwable $e) {
            // Nie przerywamy – spróbujemy i tak wymienić przez /me/accounts jeśli to user token.
            Log::warning('FB debug_token warning (continue anyway): ' . $e->getMessage());
        }

        // Na tym etapie traktujemy go jako USER TOKEN – spróbujmy pobrać PAGE TOKEN
        $r = Http::get("{$this->baseUrl}/me/accounts", [
            'fields'       => 'id,name,access_token',
            'access_token' => $token,
        ]);

        $data = $this->guard($r, 'me/accounts');

        $page = collect($data['data'] ?? [])->firstWhere('id', $pageId);
        if (!$page || empty($page['access_token'])) {
            Log::error('Nie udało się pobrać PAGE TOKEN dla wskazanego FB_PAGE_ID.', [
                'page_id' => $pageId,
                'me.accounts' => $data,
            ]);
            throw new RuntimeException('Nie udało się uzyskać Page Access Tokenu. Upewnij się, że fbToken to USER TOKEN z uprawnieniami pages_*, a konto ma rolę na stronie.');
        }

        return $page['access_token'];
    }

    /**
     * Dodaje appsecret_proof, jeśli mamy APP_SECRET (zalecane w produkcji).
     */
    protected function withSecurity(array $params): array
    {
        if ($this->appSecret && !empty($params['access_token'])) {
            $params['appsecret_proof'] = hash_hmac('sha256', $params['access_token'], $this->appSecret);
        }
        return $params;
    }

    /**
     * Wspólna walidacja odpowiedzi z Graph API.
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
     * Post tekstowy na /{pageId}/feed (wymaga PAGE TOKEN).
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
     * Post ze zdjęciem (/photos) – jedno zdjęcie, opcjonalny caption.
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
     * Post z wieloma zdjęciami: upload unpublished + feed z attached_media.
     */
    public function postMultipleImages(?string $message, array $urls): array
    {
        $attached = [];

        foreach ($urls as $url) {
            if (!is_string($url) || trim($url) === '') {
                continue;
            }

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
            throw new RuntimeException('Brak załączonych zdjęć (attached_media jest puste).');
        }

        $feedPayload = $this->withSecurity([
            'message'        => $message ?? '',
            'attached_media' => json_encode($attached),
            'access_token'   => $this->accessToken,
        ]);

        $resp = Http::asForm()->post("{$this->baseUrl}/{$this->pageId}/feed", $feedPayload);
        return $this->guard($resp, 'createFeedWithMedia');
    }
}
