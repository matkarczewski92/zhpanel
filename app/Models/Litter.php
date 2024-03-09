<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Litter extends Model
{
    use HasFactory;
    protected $table = 'litters';

    public function animalMale(): HasOne
    {
        return $this->hasOne(Animal::class, 'id', 'parent_male');
    }

    public function animalFemale(): HasOne
    {
        return $this->hasOne(Animal::class, 'id', 'parent_female');
    }

    public function litterMainPhoto(): HasOne
    {
        return $this->hasOne(LitterPhotoGallery::class, 'litter_id', 'id')->where('main_photo', '=', 1);
    }

    public function litterAdnotations(): HasOne
    {
        return $this->hasOne(LitterAdnotations::class, 'litter_id', 'id');
    }

    public function animalGallery(): HasMany
    {
        return $this->hasMany(LitterPhotoGallery::class, 'litter_id', 'id');
    }

    public function getPossibleOffspring(): HasMany
    {
        return $this->hasMany(LittersPairing::class, 'litter_id', 'id');
    }
}
