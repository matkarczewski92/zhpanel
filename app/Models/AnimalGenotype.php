<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AnimalGenotype extends Model
{
    use HasFactory;
    protected $table = 'animal_genotype';

    public function genotypeCategory(): HasOne
    {
        return $this->hasOne(AnimalGenotypeCategory::class, 'id', 'genotype_id');
    }
}
