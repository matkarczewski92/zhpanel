<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AnimalOffer extends Model
{
    use HasFactory;

    public function offerReservation(): HasOne
    {
        return $this->hasOne(AnimalOfferReservation::class, 'offer_id', 'id');
    }
    public function animalDetails(): HasOne
    {
        return $this->hasOne(Animal::class, 'id', 'animal_id');
    }
}
