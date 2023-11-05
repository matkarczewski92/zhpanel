<?php

namespace App\Http\Controllers;

use App\Models\AnimalOffer;
use App\Models\AnimalPhotoGallery;
use Illuminate\Http\Request;

class WebController extends Controller
{
    public function index()
    {
        return view('welcome', [
            'offers' => AnimalOffer::where('sold_date', NULL)->get(),
            'gallery' => AnimalPhotoGallery::where('webside', '=', 1)->get(),
        ]);
    }
}
