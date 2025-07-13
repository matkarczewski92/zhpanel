<?php

namespace App\Http\Controllers;

use App\Interfaces\AnimalRepositoryInterface;
use App\Interfaces\LitterRepositoryInterface;
use App\Models\AnimalOffer;
use App\Models\AnimalPhotoGallery;
use App\Models\Litter;

class WebController extends Controller
{
    private AnimalRepositoryInterface $animalRepo;
    private LitterRepositoryInterface $litterRepo;

    public function __construct(
        AnimalRepositoryInterface $animalRepo,
        LitterRepositoryInterface $litterRepo
    ) {
        $this->animalRepo = $animalRepo;
        $this->litterRepo = $litterRepo;
    }

    public function index()
    {
        $actualYear = date('Y');
        $offers = AnimalOffer::with('animalDetails')
            ->whereNull('sold_date')
            ->get()
            ->filter(function ($offer) {
                return $offer->animalDetails && $offer->animalDetails->public_profile == 1;
            })
            ->groupBy(function ($offer) {
                return $offer->animalDetails->litter_id;
            });

        return view('welcome', [
            'offers' => $offers,
            'gallery' => AnimalPhotoGallery::where('webside', '=', 1)->get(),
            'litterPlans' => Litter::where('season', $actualYear)->orderBy('category')->get(),
            'animalRepo' => $this->animalRepo,
            'litterRepo' => $this->litterRepo,
        ]);
    }
}
