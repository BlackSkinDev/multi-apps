<?php

namespace App\Http\Controllers\Api\Project;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class ProjectTaskAssignmentController extends Controller
{

    /**
     * unassign a project task from currently assigned user
     */
    public function update(Task $task)
    {
        $task->update(['user_id'=>null]);
        return successResponse();
    }
}
