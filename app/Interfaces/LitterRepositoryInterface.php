<?php

namespace App\Interfaces;

interface LitterRepositoryInterface
{
    public function all();

    public function getById(int $litterId);

    public function getAvailable();

    public function getByParents(int $animalId);
}
