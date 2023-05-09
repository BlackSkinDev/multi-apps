<?php

namespace App\Http\Controllers\Api\Project;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class ProjectUserController extends Controller
{
    /**
     * get all projects team members
     */
    public function index():JsonResponse
    {
        $searchTerm = request('q');
        $users = User::when($searchTerm,function ($query) use ($searchTerm){
            return $query->where('name', 'LIKE', "%$searchTerm%");
        })->get();
        return successResponse(UserResource::collection($users));
    }

    /**
     * get a single member
     */
    public function show(User $user):JsonResponse
    {
        return successResponse(UserResource::make($user));
    }
}
