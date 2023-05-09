<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Project\ProjectController;
use App\Http\Controllers\Api\Project\ProjectTaskAssignmentController;
use App\Http\Controllers\Api\Project\ProjectTaskController;
use App\Http\Controllers\Api\Project\ProjectUserController;
use App\Http\Controllers\Api\ProjectDevStage\ProjectDevStageController;
use App\Http\Controllers\Api\Task\MediaController;
use App\Http\Controllers\Api\Task\TaskPositionController;
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

    Route::prefix('auth')->group(function () {

        Route::post('register',[AuthController::class,'register']);
        Route::post('login',[AuthController::class,'login']);
        Route::post('refresh-token',[AuthController::class,'refreshToken']);

        Route::middleware('auth:sanctum')->group(function () {
            Route::get('user', [AuthController::class, 'user']);
            Route::post('logout', [AuthController::class,'logout'])->middleware('auth:sanctum');
        });

    });


    Route::prefix('projects')->middleware('auth:sanctum')->group(function () {
        Route::get('', [ProjectController::class, 'index']);
        Route::post('', [ProjectController::class, 'store']);
        Route::get('{project}', [ProjectController::class, 'show']);
        Route::patch('{project}', [ProjectController::class, 'update']);
        Route::get('{project}/tasks', [ProjectTaskController::class, 'index']);
        Route::post('{project}/tasks', [ProjectTaskController::class, 'store']);
    });

    Route::prefix('tasks')->middleware('auth:sanctum')->group(function () {
        Route::patch( '{task}',[ProjectTaskController::class,'update']);
        Route::delete('{task}',[ProjectTaskController::class,'destroy']);
        Route::patch( '{task}/unassign',[ProjectTaskAssignmentController::class,'update']);
        Route::patch( '{task}/move',[TaskPositionController::class,'update']);
    });

    Route::prefix('users')->middleware('auth:sanctum')->group(function () {
        Route::get('',[ProjectUserController::class,'index']);
        Route::get('{user}',[ProjectUserController::class,'show']);
    });

    Route::post('upload',[MediaController::class,'store'])->middleware('auth:sanctum');

    Route::prefix('projects-dev-stages')->middleware('auth:sanctum')->group(function () {
        Route::get('',[ProjectDevStageController::class,'index']);
    });


});
