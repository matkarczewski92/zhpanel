<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FacebookService
{
    protected $pageId;
    protected $accessToken;

    public function __construct()
    {
        $this->pageId = env('FB_PAGE_ID');
        $this->accessToken = env('FB_PAGE_TOKEN'); // Zmienione z FB_USER_TOKEN_LONG
    }

    public function postImage($message, $url)
    {
        return Http::post("https://graph.facebook.com/{$this->pageId}/photos", [
            'url' => $url,
            'caption' => $message,
            'access_token' => $this->accessToken
        ])->json();
    }

    public function postMultipleImages($message, array $urls)
    {
        $attachedMedia = [];

        foreach ($urls as $url) {
            $res = Http::post("https://graph.facebook.com/{$this->pageId}/photos", [
                'url' => $url,
                'published' => false,
                'access_token' => $this->accessToken
            ])->json();

            if (!empty($res['id'])) {
                $attachedMedia[] = ['media_fbid' => $res['id']];
            }
        }

        return Http::post("https://graph.facebook.com/{$this->pageId}/feed", [
            'message' => $message,
            'attached_media' => $attachedMedia,
            'access_token' => $this->accessToken
        ])->json();
    }
}
