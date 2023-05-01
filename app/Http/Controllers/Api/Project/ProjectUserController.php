<?php

namespace App\Http\Controllers\Api\Project;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Models\User;

class ProjectUserController extends Controller
{
    /**
     * get all projects team members
     */
    public function index()
    {
        $searchTerm = request('q');
        $users = User::when($searchTerm,function ($query) use ($searchTerm){
            return $query->where('name', 'LIKE', "%$searchTerm%");
        })->get();
        return successResponse(UserResource::collection($users));
    }
}
