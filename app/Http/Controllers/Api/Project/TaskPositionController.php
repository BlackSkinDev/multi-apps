<?php

namespace App\Http\Controllers\Api\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskPositionRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskPositionController extends Controller
{
    /**
     * update task for project
     */
    public function update(TaskPositionRequest $request,Task $task)
    {
        $task->update([
            'project_dev_stage_id' => $request->project_dev_stage_id,
            'position'             => round($request->position,5)
        ]);


        return successResponse();
    }
}
