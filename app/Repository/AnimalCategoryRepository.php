<?php

namespace App\Repository;

use App\Interfaces\AnimalCategoryRepositoryInterface;
use App\Models\AnimalCategory;

class AnimalCategoryRepository implements AnimalCategoryRepositoryInterface
{
    public function all()
    {
        return AnimalCategory::all();
    }
}
