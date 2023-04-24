<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\CreateTaskRequest;
use App\Http\Resources\Project\ProjectTaskResource;
use App\Models\Project;
use App\Models\ProjectDevStage;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectTaskController extends Controller
{
    /**
     * get all projects
     */
    public function index(Project $project)
    {
        $tasks = ProjectDevStage::enabled()
            ->with(['tasks' => function($query) use ($project) {
                $query->where('project_id', $project->id)->with('user');
            }])
            ->orderBy('priority','asc')
            ->get();

        return successResponse(ProjectTaskResource::collection($tasks));
    }

    /**
     * create new task for project
     */
    public function store(CreateTaskRequest $request,Project $project)
    {
         $data = array_merge($request->validated(),['project_id'=>$project->id]);
         Task::create($data);
         return successResponse();
    }

}
