<?php

namespace App\Interfaces;

interface AnimalOfferRepositoryInterface
{
    public function all();
    public function getById($id);
}
