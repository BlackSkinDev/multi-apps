<?php

namespace App\Http\Controllers\Api\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\CreateProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Resources\Project\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * get all projects
     */
    public function index()
    {
        $projects = Project::latest()->get();
        return successResponse(ProjectResource::collection($projects));
    }


    /**
     * create new Project
     */
    public function store(CreateProjectRequest $request)
    {
        Project::create($request->Validated());
        return successResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show($ref)
    {
        $project = Project::where('reference',$ref)->firstorfail();
        return successResponse(ProjectResource::make($project));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $project->update($request->validated());
        return successResponse();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
}
