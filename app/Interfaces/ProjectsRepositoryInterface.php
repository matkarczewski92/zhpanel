<?php

namespace App\Interfaces;

interface ProjectsRepositoryInterface
{
    public function all();

    public function getById(int $id);
}
