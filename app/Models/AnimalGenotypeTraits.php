<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AnimalGenotypeTraits extends Model
{
    use HasFactory;
    protected $table = 'animal_genotype_traits';

    public function getTraitsDictionary(): HasMany
    {
        return $this->hasMany(AnimalGenotypeTraitsDictionary::class, 'trait_id', 'id');
    }
}
