<?php

namespace App\Interfaces;

interface AnimalRepositoryInterface
{
    public function all();

    public function getAllInBreeding();

    public function getById(int $id);

    public function lastWeight(int $animalId);

    public function sexName(int $value);

    public function feedInterval(int $animalId);

    public function lastFeed(int $animalId);

    public function nextFeed(int $animalId);
}
