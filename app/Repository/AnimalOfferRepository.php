<?php

namespace App\Repository;

use App\Interfaces\AnimalOfferRepositoryInterface;
use App\Models\AnimalCategory;
use App\Models\AnimalOffer;

class AnimalOfferRepository implements AnimalOfferRepositoryInterface
{
    public function all()
    {
        return AnimalOffer::where('sold_date', NULL)->orderBy('animal_id', 'ASC')->get();
    }

}
