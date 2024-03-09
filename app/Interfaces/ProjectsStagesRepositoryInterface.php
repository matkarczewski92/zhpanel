<?php

namespace App\Interfaces;

use App\Models\Projects;

interface ProjectsStagesRepositoryInterface
{
    public function getById(int $id);

    public function getByProject(Projects $project);

    public function getBySeason(int $season, Projects $project);
}
