<?php

namespace App\Interfaces;

interface AnimalRepositoryInterface
{
    public function all();

    public function getAllInBreeding();

    public function getAllInBreedingMales();

    public function getAllInBreedingFemales();
    
    public function getAllUnsoldAnimals();

    public function getUnsoldOffer();

    public function getById(int $id);

    public function getByToken(string $token);

    public function getByLitter(int $litterId);

    public function sexName(int $value);

    public function feedInterval(int $animalId);

    public function lastFeed(int $animalId);

    public function nextFeed(int $animalId);

    public function timeToFeed(int $animalId);

    public function feedCount(int $animalId);

    public function lastWeight(int $animalId);

    public function lastWeighting(int $animalId);

    public function nextWeight(int $animalId);

    public function timeToWeight(int $animalId);

    public function animalStatus(int $animalId);
}
