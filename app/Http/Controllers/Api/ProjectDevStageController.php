<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectDevStage\ProjectDevStageResource;
use App\Models\ProjectDevStage;
use Illuminate\Http\Request;

class ProjectDevStageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stages =  ProjectDevStage::enabled()->get();
        return successResponse(ProjectDevStageResource::collection($stages));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectDevStage $projectDevStage)
    {
        //
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProjectDevStage $projectDevStage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectDevStage $projectDevStage)
    {
        //
    }
}
