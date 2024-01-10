<?php

namespace App\Interfaces;

interface FeedRepositoryInterface
{
    public function all();

    public function getById(int $feedId);
}
