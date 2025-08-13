// app/Services/FacebookService.php
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

private function guard(Http\Response $resp, string $context): array
{
    if ($resp->failed()) {
        Log::error("FB API FAILED ({$context})", ['status' => $resp->status(), 'body' => $resp->body()]);
        throw new RuntimeException("Facebook API error ({$context}): " . $resp->body());
    }
    $data = $resp->json();
    if (isset($data['error'])) {
        Log::error("FB API ERROR FIELD ({$context})", ['error' => $data['error']]);
        throw new RuntimeException("Facebook API error ({$context}): " . json_encode($data['error']));
    }
    return $data;
}

public function postText(string $message): array
{
    $resp = Http::asForm()->post("{$this->baseUrl}/{$this->pageId}/feed", [
        'message'      => $message,
        'access_token' => $this->accessToken,
    ]);
    return $this->guard($resp, 'postText'); // rzuci wyjątek jeśli coś nie tak
}

public function postImage(?string $message, string $url): array
{
    $resp = Http::asForm()->post("{$this->baseUrl}/{$this->pageId}/photos", [
        'url'          => $url,
        'caption'      => $message ?? '',
        'access_token' => $this->accessToken,
    ]);
    return $this->guard($resp, 'postImage');
}

public function postMultipleImages(?string $message, array $urls): array
{
    $attached = [];
    foreach ($urls as $url) {
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

    $resp = Http::asForm()->post("{$this->baseUrl}/{$this->pageId}/feed", [
        'message'        => $message ?? '',
        'attached_media' => json_encode($attached),
        'access_token'   => $this->accessToken,
    ]);
    return $this->guard($resp, 'createFeedWithMedia');
}
