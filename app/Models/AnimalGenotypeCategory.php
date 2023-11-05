<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimalGenotypeCategory extends Model
{
    use HasFactory;

    protected $table = "animal_genotype_category";
    protected $fillable = ['name'];
}
