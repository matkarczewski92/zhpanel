<?php

namespace App\Repository;

use App\Interfaces\AnimalTypeRepositoryInterface;
use App\Models\AnimalType;

class AnimalTypeRepository implements AnimalTypeRepositoryInterface
{
    public function all()
    {
        return AnimalType::all();
    }
}
