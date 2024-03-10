<?php

namespace App\Http\Controllers;

use App\Interfaces\AnimalRepositoryInterface;
use App\Interfaces\ProjectsRepositoryInterface;
use App\Interfaces\ProjectsStagesRepositoryInterface;
use App\Models\Projects;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    protected ProjectsRepositoryInterface $projectRepo;
    protected ProjectsStagesRepositoryInterface $stageRepo;
    protected AnimalRepositoryInterface $animalRepo;

    public function __construct(
        ProjectsRepositoryInterface $projectRepo,
        ProjectsStagesRepositoryInterface $stageRepo,
        AnimalRepositoryInterface $animalRepo,
    ) {
        $this->projectRepo = $projectRepo;
        $this->stageRepo = $stageRepo;
        $this->animalRepo = $animalRepo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('projects', [
            'projects' => $this->projectRepo->all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $project = new Projects();
        $project->title = $request->title;
        $project->save();

        return redirect()->route('projects.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $projectsId)
    {
        $project = $this->projectRepo->getById($projectsId);

        return view('projects.projects-profile',
            [
                'project' => $project,
                'stages' => $this->stageRepo->getByProject($project),
                'animalsMales' => $this->animalRepo->getAllInBreedingMales(),
                'animalsFemales' => $this->animalRepo->getAllInBreedingFemales(),
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Projects $projects)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Projects $projects)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Projects $project)
    {
        $project->delete();

        return redirect()->route('projects.index');
    }
}
