<?php

namespace App\Http\Controllers;

use App\Interfaces\AnimalRepositoryInterface;
use App\Models\AnimalOffer;
use App\Models\AnimalPhotoGallery;
use App\Models\Litter;

class WebController extends Controller
{
    private AnimalRepositoryInterface $animalRepo;

    public function __construct(AnimalRepositoryInterface $animalRepo)
    {
        $this->animalRepo = $animalRepo;
    }

    public function index()
    {
        $actualYear = date('Y');

        return view('welcome', [
            'offers' => AnimalOffer::where('sold_date', null)->get(),
            'gallery' => AnimalPhotoGallery::where('webside', '=', 1)->get(),
            'litterPlans' => Litter::where('season', $actualYear)->orderBy('category')->get(),
            'animalRepo' => $this->animalRepo,
        ]);
    }
}
