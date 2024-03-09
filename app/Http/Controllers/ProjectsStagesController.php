<?php

namespace App\Http\Controllers;

use App\Interfaces\ProjectsRepositoryInterface;
use App\Interfaces\ProjectsStagesRepositoryInterface;
use App\Models\Litter;
use App\Models\LittersPairing;
use App\Models\Projects;
use App\Models\ProjectsStages;
use Illuminate\Http\Request;

class ProjectsStagesController extends Controller
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
    public function store(Projects $project, Request $request)
    {
        $data = $request->all();
        $data['project_id'] = $project->id;
        ProjectsStages::create($data);

        return redirect()->route('projects.show', $project->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Projects $project, ProjectsStages $stage)
    {
        $availableLitters = ($stage->parent_male_id and $stage->parent_female_id) ? Litter::where('parent_male', $stage->parent_male_id)->where('parent_female', $stage->parent_female_id)->get() : null;

        return view('projects.profile.projects-profile-stages-edit', [
            'project' => $project,
            'stage' => $stage,
            'litter' => $availableLitters,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Projects $project, ProjectsStages $stage)
    {
        $stage->delete();

        return redirect()->route('projects.show', $project->id);
    }

    public function createLitter(Projects $project, ProjectsStages $stage)
    {
        $templateIo = ($stage->parent_male_id and $stage->parent_female_id) ? Litter::where('parent_male', $stage->parent_male_id)->where('parent_female', $stage->parent_female_id)->where('category', 3)->first() : null;
        if ($templateIo) {
            $template = $templateIo->id;

            $litter = new Litter();
            $litter->category = 2;
            $litter->litter_code = 'PROJEKT';
            $litter->parent_male = $stage->parent_male_id;
            $litter->parent_female = $stage->parent_female_id;
            $litter->season = $stage->season;
            $litter->save();

            $littersPairings = LittersPairing::where('litter_id', $template)->get();
            foreach ($littersPairings as $lP) {
                $newPairing = new LittersPairing();
                $newPairing->percent = $lP->percent;
                $newPairing->title_vis = $lP->title_vis;
                $newPairing->title_het = $lP->title_het;
                $newPairing->litter_id = $litter->id;
                $newPairing->img_url = $lP->img_url;
                $newPairing->save();
            }
        }

        return redirect()->route('projects.stages.edit', [$project->id, $stage->id]);
    }
}
