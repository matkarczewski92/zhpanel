<?php

namespace App\Repository;

use App\Interfaces\LitterRepositoryInterface;
use App\Models\Litter;

class LitterRepository implements LitterRepositoryInterface
{
    public function all()
    {
        return Litter::all();
    }

    public function getById(int $litterId)
    {
        return Litter::findOrFail($litterId);
    }

    public function getAvailable()
    {
        return Litter::where('category', 1)->orWhere('category', 4)->get();
    }

    public function getByParents(int $animalId)
    {
        return Litter::where('parent_male', '=', $animalId)->orWhere('parent_female', '=', $animalId)->get();
    }
}
