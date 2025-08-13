<?php

namespace App\Http\Controllers;

use App\Services\FacebookService;
use Illuminate\Http\Request;

class FacebookController extends Controller
{
    protected $fb;

    public function __construct(FacebookService $fb)
    {
        $this->fb = $fb;
    }

    public function postText(Request $request)
    {
        return $this->fb->postText($request->message);
    }

    public function postImage(Request $request)
    {
        return $this->fb->postImage($request->message, $request->url);
    }

    public function postMultipleImages(Request $request)
    {
        // Rozdzielenie URL-i po przecinku i usunięcie spacji
        $urlsArray = array_map('trim', explode(',', $request->urls));

        return $this->fb->postMultipleImages($request->message, $urlsArray);
    }


}
