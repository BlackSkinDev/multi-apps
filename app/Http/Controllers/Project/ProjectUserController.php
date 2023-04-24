<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectUserController extends Controller
{
    /**
     * get all projects team members
     */
    public function index()
    {

        $users = User::get();

        return successResponse(UserResource::collection($users));
    }
}
