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
        try {
            $this->fb->postText($request->message);
            return redirect(url()->previous() . '?OK');
        } catch (\Throwable $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function postImage(Request $request)
    {
        try {
            $this->fb->postImage($request->message, $request->url);
            return redirect(url()->previous() . '?OK');
        } catch (\Throwable $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function postMultipleImages(Request $request)
    {
        try {
            $urlsArray = array_map('trim', explode(',', $request->urls));
            $this->fb->postMultipleImages($request->message, $urlsArray);
            return redirect(url()->previous() . '?OK');
        } catch (\Throwable $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    


}
