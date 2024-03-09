<?php

namespace App\Repository;

use App\Interfaces\ProjectsRepositoryInterface;
use App\Models\Projects;

class ProjectsRepository implements ProjectsRepositoryInterface
{
    public function all()
    {
        return Projects::all();
    }

    public function getById(int $id)
    {
        return Projects::findOrFail($id);
    }
}
