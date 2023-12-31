<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Animal extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'sex ', 'date_of_birth', 'animal_type_id', 'litter_id', 'feed_id', 'feed_interval', 'animal_category_id', 'public_profile', 'public_profile_tag', 'web_galery'];

    public function animalCategory(): HasOne
    {
        return $this->hasOne(AnimalCategory::class, 'id', 'animal_category_id');
    }

    public function animalType(): HasOne
    {
        return $this->hasOne(AnimalType::class, 'id', 'animal_type_id');
    }

    public function animalFeed(): HasOne
    {
        return $this->hasOne(Feed::class, 'id', 'feed_id');
    }

    public function animalLitter(): HasOne
    {
        return $this->hasOne(Litter::class, 'id', 'litter_id');
    }

    public function animalOffer(): HasOne
    {
        return $this->hasOne(AnimalOffer::class, 'animal_id', 'id');
    }

    public function animalMainPhoto(): HasOne
    {
        return $this->hasOne(AnimalPhotoGallery::class, 'animal_id', 'id')->where('main_profil_photo', '=', 1);
    }

    public function animalWeights(): HasMany
    {
        return $this->hasMany(AnimalWeight::class, 'animal_id', 'id')->orderBy('created_at', 'desc');
    }

    public function animalMolts(): HasMany
    {
        return $this->hasMany(AnimalMolt::class, 'animal_id', 'id');
    }

    public function animalFeedings(): HasMany
    {
        return $this->hasMany(AnimalFeedings::class, 'animal_id', 'id');
    }

    public function animalGallery(): HasMany
    {
        return $this->hasMany(AnimalPhotoGallery::class, 'animal_id', 'id');
    }

    public function animalGenotype(): HasMany
    {
        return $this->hasMany(AnimalGenotype::class, 'animal_id', 'id');
    }

    public function animalWinterings(): HasMany
    {
        return $this->hasMany(Wintering::class, 'animal_id', 'id')->orderBy('season', 'desc');
    }
}
