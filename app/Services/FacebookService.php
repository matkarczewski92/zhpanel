<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class FacebookService
{
    private string $pageId;
    private string $accessToken;
    private string $baseUrl = 'https://graph.facebook.com/v20.0';

    public function __construct()
    {
        // Page ID nadal z .env (albo też możesz pobrać z bazy: systemConfig('fbPageId'))
        $this->pageId = (string) env('FB_PAGE_ID');

        // <-- KLUCZOWA ZMIANA: token z bazy
        $token = (string) (systemConfig('fbToken') ?? '');

        if ($token === '') {
            throw new RuntimeException('Brak Page Access Token w systemConfig("fbToken").');
        }

        $this->accessToken = $token;
    }

    /** Post tekstowy */
    public function postText(string $message): array
    {
        return Http::asForm()->post(
            "{$this->baseUrl}/{$this->pageId}/feed",
            [
                'message'      => $message,
                'access_token' => $this->accessToken,
            ]
        )->json();
    }

    /** Pojedynczy obrazek (po URL) */
    public function postImage(?string $message, string $url): array
    {
        return Http::asForm()->post(
            "{$this->baseUrl}/{$this->pageId}/photos",
            [
                'url'          => $url,
                'caption'      => $message ?? '',
                'access_token' => $this->accessToken,
            ]
        )->json();
    }

    /** Wiele obrazów po URL (unpublished -> attached_media) */
    public function postMultipleImages(?string $message, array $urls): array
    {
        $attachedMedia = [];

        foreach ($urls as $url) {
            $res = Http::asForm()->post(
                "{$this->baseUrl}/{$this->pageId}/photos",
                [
                    'url'          => $url,
                    'published'    => false,
                    'access_token' => $this->accessToken,
                ]
            )->json();

            if (!empty($res['id'])) {
                $attachedMedia[] = ['media_fbid' => $res['id']];
            }
        }

        return Http::asForm()->post(
            "{$this->baseUrl}/{$this->pageId}/feed",
            [
                'message'        => $message ?? '',
                'attached_media' => json_encode($attachedMedia),
                'access_token'   => $this->accessToken,
            ]
        )->json();
    }

    /** (Opcjonalnie) upload wielu plików z dysku */
    public function postMultipleUploads(?string $message, array $files): array
    {
        $attachedMedia = [];

        foreach ($files as $file) {
            /** @var \Illuminate\Http\UploadedFile|\Illuminate\Http\File $file */
            $path = method_exists($file, 'getRealPath') ? $file->getRealPath() : (string) $file;
            $name = method_exists($file, 'getClientOriginalName') ? $file->getClientOriginalName() : basename($path);

            $res = Http::attach('source', fopen($path, 'r'), $name)
                ->asMultipart()
                ->post("{$this->baseUrl}/{$this->pageId}/photos", [
                    'published'    => false,
                    'access_token' => $this->accessToken,
                ])->json();

            if (!empty($res['id'])) {
                $attachedMedia[] = ['media_fbid' => $res['id']];
            }
        }

        return Http::asForm()->post(
            "{$this->baseUrl}/{$this->pageId}/feed",
            [
                'message'        => $message ?? '',
                'attached_media' => json_encode($attachedMedia),
                'access_token'   => $this->accessToken,
            ]
        )->json();
    }
}
