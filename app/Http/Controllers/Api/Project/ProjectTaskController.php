<?php

namespace App\Http\Controllers\Api\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\Project\ProjectTaskResource;
use App\Models\Project;
use App\Models\ProjectDevStage;
use App\Models\Task;

class ProjectTaskController extends Controller
{
    /**
     * get all projects tasks
     */
    public function index(Project $project)
    {
        $tasks = ProjectDevStage::enabled()
            ->with(['tasks' => function($query) use ($project) {
                $query->where('project_id', $project->id)->with('user')
                ->orderBy('position','asc');
            }])
            ->orderBy('position','asc')
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

    /**
     * update task for project
     */
    public function update(UpdateTaskRequest $request,Task $task)
    {
        $task->update($request->validated());
        return successResponse();
    }


    /**
     * delete task for project
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return successResponse();
    }

}
