<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class FacebookService
{
    /**
     * Bazowy endpoint Graph API (ustawiony na v20.0)
     */
    protected string $baseUrl = 'https://graph.facebook.com/v20.0';

    /**
     * ID strony (Page ID), na którą publikujemy
     */
    protected string $pageId;

    /**
     * Page Access Token (z bazy lub .env)
     */
    protected string $accessToken;

    public function __construct()
    {
        $this->pageId = (string) env('FB_PAGE_ID');

        // Jeśli korzystasz z tokenu zapisanego w bazie:
        // Upewnij się, że helper systemConfig() jest autoloadowany
        $this->accessToken = (string) (function_exists('systemConfig')
            ? (systemConfig('fbToken') ?? '')
            : '');

        // Fallback na .env jeśli z bazy nic nie przyszło
        if ($this->accessToken === '') {
            $this->accessToken = (string) env('FB_PAGE_TOKEN', '');
        }
    }

    /**
     * Wspólna walidacja odpowiedzi z Graph API.
     * Rzuca wyjątek i loguje szczegóły, jeśli coś poszło nie tak.
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
     * Post tekstowy na /{pageId}/feed
     */
    public function postText(string $message): array
    {
        $resp = Http::asForm()->post("{$this->baseUrl}/{$this->pageId}/feed", [
            'message'      => $message,
            'access_token' => $this->accessToken,
        ]);

        return $this->guard($resp, 'postText');
    }

    /**
     * Post ze zdjęciem (/photos) – jedno zdjęcie, opcjonalny caption
     */
    public function postImage(?string $message, string $url): array
    {
        $resp = Http::asForm()->post("{$this->baseUrl}/{$this->pageId}/photos", [
            'url'          => $url,
            'caption'      => $message ?? '',
            'access_token' => $this->accessToken,
        ]);

        return $this->guard($resp, 'postImage');
    }

    /**
     * Post z wieloma zdjęciami – najpierw upload unpublished photos,
     * potem publikacja posta z attached_media.
     */
    public function postMultipleImages(?string $message, array $urls): array
    {
        $attached = [];

        foreach ($urls as $url) {
            if (!is_string($url) || trim($url) === '') {
                continue;
            }

            $r = Http::asForm()->post("{$this->baseUrl}/{$this->pageId}/photos", [
                'url'          => $url,
                'published'    => false,
                'access_token' => $this->accessToken,
            ]);

            $photo = $this->guard($r, 'uploadPhoto(unpublished)');

            if (!empty($photo['id'])) {
                $attached[] = ['media_fbid' => $photo['id']];
            }
        }

        if (empty($attached)) {
            throw new RuntimeException('Brak załączonych zdjęć (attached_media jest puste).');
        }

        // UWAGA: attached_media musi być przekazane jako JSON string
        $resp = Http::asForm()->post("{$this->baseUrl}/{$this->pageId}/feed", [
            'message'        => $message ?? '',
            'attached_media' => json_encode($attached),
            'access_token'   => $this->accessToken,
        ]);

        return $this->guard($resp, 'createFeedWithMedia');
    }
}
