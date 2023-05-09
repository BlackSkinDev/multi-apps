<?php

namespace App\Http\Controllers\Api\ProjectDevStage;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectDevStage\ProjectDevStageResource;
use App\Models\ProjectDevStage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectDevStageController extends Controller
{
    /**
     * Fetch all project dev stages
     */
    public function index():JsonResponse
    {
        $stages =  ProjectDevStage::enabled()->get();
        return successResponse(ProjectDevStageResource::collection($stages));
    }


    /**
     * Store a new project dev stage
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Fetch a project dev stage
     */
    public function show(ProjectDevStage $projectDevStage)
    {
        //
    }



    /**
     * Update a project dev stage
     */
    public function update(Request $request, ProjectDevStage $projectDevStage)
    {
        //
    }

    /**
     * Delete a project dev stage
     */
    public function destroy(ProjectDevStage $projectDevStage)
    {
        //
    }
}
