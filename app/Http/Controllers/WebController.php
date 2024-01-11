<?php

namespace App\Http\Controllers;

use App\Interfaces\AnimalRepositoryInterface;
use App\Models\AnimalOffer;
use App\Models\AnimalPhotoGallery;

class WebController extends Controller
{
    private AnimalRepositoryInterface $animalRepo;

    public function __construct(AnimalRepositoryInterface $animalRepo)
    {
        $this->animalRepo = $animalRepo;
    }

    public function index()
    {
        return view('welcome', [
            'offers' => AnimalOffer::where('sold_date', null)->get(),
            'gallery' => AnimalPhotoGallery::where('webside', '=', 1)->get(),
            'animalRepo' => $this->animalRepo,
        ]);
    }
}
