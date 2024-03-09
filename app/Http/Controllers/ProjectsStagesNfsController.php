<?php

namespace App\Http\Controllers;

use App\Interfaces\ProjectsRepositoryInterface;
use App\Interfaces\ProjectsStagesRepositoryInterface;
use App\Models\LittersPairing;
use App\Models\Projects;
use App\Models\ProjectsStages;
use App\Models\ProjectsStagesNfs;
use Illuminate\Http\Request;

class ProjectsStagesNfsController extends Controller
{
    protected ProjectsRepositoryInterface $projectRepo;
    protected ProjectsStagesRepositoryInterface $stageRepo;

    public function __construct(
        ProjectsRepositoryInterface $projectRepo,
        ProjectsStagesRepositoryInterface $stageRepo,
    ) {
        $this->projectRepo = $projectRepo;
        $this->stageRepo = $stageRepo;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Projects $project, ProjectsStages $stage, Request $request)
    {
        if (!is_null($request->possibleOff)) {
            $posOff = LittersPairing::findOrFail($request->possibleOff);
            $store = new ProjectsStagesNfs();
            $store->stage_id = $stage->id;
            $store->percent = $posOff->percent;
            $store->title = $posOff->title_vis.' '.$posOff->title_het;
            $store->save();
        } else {
            $store = new ProjectsStagesNfs();
            $store->stage_id = $stage->id;
            $store->percent = $request->percent;
            $store->title = $request->title;
            $store->save();
        }

        return redirect()->route('projects.stages.edit', [$project, $stage]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Projects $project, ProjectsStages $stage, ProjectsStagesNfs $nf)
    {
        $nf->delete();

        return redirect()->route('projects.stages.edit', [$project, $stage]);
    }
}
