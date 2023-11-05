<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AnimalPhotoGallery extends Model
{
    use HasFactory;
    protected $table = 'animal_photo_gallery';

    public function animalDetails(): HasOne
    {
        return $this->hasOne(Animal::class, 'id', 'animal_id');
    }
}
