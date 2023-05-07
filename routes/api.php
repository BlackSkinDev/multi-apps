<?php

use App\Http\Controllers\Api\Project\ProjectController;
use App\Http\Controllers\Api\Project\ProjectDevStageController;
use App\Http\Controllers\Api\Project\ProjectTaskAssignmentController;
use App\Http\Controllers\Api\Project\ProjectTaskController;
use App\Http\Controllers\Api\Project\MediaController;
use App\Http\Controllers\Api\Project\ProjectUserController;
use App\Http\Controllers\Api\Project\TaskPositionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('kinban-app')->group(function () {

    Route::prefix('projects')->group(function () {
        Route::get('',[ProjectController::class,'index']);
        Route::post('',[ProjectController::class,'store']);
        Route::get('{project}',[ProjectController::class,'show']);
        Route::patch('{project}',[ProjectController::class,'update']);
        Route::get('{project}/tasks',[ProjectTaskController::class,'index']);
        Route::post('{project}/tasks',[ProjectTaskController::class,'store']);

    });

    Route::prefix('tasks')->group(function () {
        Route::patch( '{task}',[ProjectTaskController::class,'update']);
        Route::delete('{task}',[ProjectTaskController::class,'destroy']);
        Route::patch( '{task}/unassign',[ProjectTaskAssignmentController::class,'update']);
        Route::patch( '{task}/move',[TaskPositionController::class,'update']);
    });

    Route::prefix('users')->group(function () {
        Route::get('',[ProjectUserController::class,'index']);
    });

    Route::post('upload',[MediaController::class,'store']);

    Route::prefix('projects-dev-stages')->group(function () {
        Route::get('',[ProjectDevStageController::class,'index']);
    });


});
