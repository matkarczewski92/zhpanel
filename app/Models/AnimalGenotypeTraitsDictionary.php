<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AnimalGenotypeTraitsDictionary extends Model
{
    use HasFactory;
    protected $table = 'animal_genotype_traits_dictionary';

    public function genotypeCategory(): HasOne
    {
        return $this->hasOne(AnimalGenotypeCategory::class, 'id', 'category_id');
    }
    
}
