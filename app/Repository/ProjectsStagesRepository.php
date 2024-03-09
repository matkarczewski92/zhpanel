<?php

namespace App\Repository;

use App\Interfaces\ProjectsStagesRepositoryInterface;
use App\Models\Projects;
use App\Models\ProjectsStages;

class ProjectsStagesRepository implements ProjectsStagesRepositoryInterface
{
    public function getById(int $id)
    {
        return ProjectsStages::findOrFail($id);
    }

    public function getByProject(Projects $project)
    {
        return ProjectsStages::where('project_id', $project->id)->orderBy('season')->get();
    }

    public function getBySeason(int $season, Projects $project)
    {
    }
}
