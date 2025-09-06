<?php

namespace App\Http\Controllers;

use App\Interfaces\AnimalOfferRepositoryInterface;
use App\Interfaces\AnimalRepositoryInterface;
use App\Interfaces\LitterRepositoryInterface;
use App\Models\AnimalOfferReservation;
use Illuminate\Http\Request;

class PriceListController extends Controller
{
    private AnimalRepositoryInterface $animalRepo;
    private AnimalOfferRepositoryInterface $animalOffer;
    private LitterRepositoryInterface $litterRepository;

    public function __construct(
        AnimalRepositoryInterface $animalRepo,
        LitterRepositoryInterface $litterRepository,
        AnimalOfferRepositoryInterface $animalOffer
    ) {
        $this->animalRepo = $animalRepo;
        $this->litterRepository = $litterRepository;
        $this->animalOffer = $animalOffer;
    }


    public function index()
    {
        $animals = $this->animalRepo->getAllUnsoldAnimals();
        $litters = $this->litterRepository->all();
        $offers = $this->animalOffer->all();

        return view('pricelist', [
            'animals' => $animals,  
            'litters' => $litters,
            'offers' => $offers,
        ]);
    }
}
