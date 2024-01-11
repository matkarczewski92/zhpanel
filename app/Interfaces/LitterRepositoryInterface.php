<?php

namespace App\Interfaces;

interface LitterRepositoryInterface
{
    public function all();

    public function getById(int $litterId);

    public function getAvailable();

    public function getByParents(int $animalId);

    public function litterStatus(int $id);

    public function litterCategory(int $category);

    public function litterOffspringPercentCount(int $litterId);

    public function templateCount(int $femaleId, $maleId);

    public function checkNfs(int $paitngId);
}
