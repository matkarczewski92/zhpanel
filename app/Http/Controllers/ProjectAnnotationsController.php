<?php

namespace App\Http\Controllers;

use App\Models\ProjectAnnotations;
use App\Models\Projects;
use Illuminate\Http\Request;

class ProjectAnnotationsController extends Controller
{
    /**
     * Update the specified resource in storage.
     */
    public function store(Request $request, Projects $project)
    {
        $annotation = new ProjectAnnotations();
        $annotation->project_id = $project->id;
        $annotation->annotations = $request->annotations;
        $annotation->save();

        return redirect()->route('projects.show', $project->id);
    }

    public function update(Request $request, Projects $project, ProjectAnnotations $annotation)
    {
        // dd($annotation);
        $annotation->annotations = $request->annotations;
        $annotation->save();

        return redirect()->route('projects.show', $project->id)->with('status', 'ok');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectAnnotations $projectAnnotations)
    {
    }
}
