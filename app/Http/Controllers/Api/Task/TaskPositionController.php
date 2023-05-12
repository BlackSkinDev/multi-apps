<?php

namespace App\Http\Controllers\Api\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\TaskPositionRequest;
use App\Models\Task;

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
