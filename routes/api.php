<?php

use App\Http\Controllers\Api\Project\ProjectController;
use App\Http\Controllers\Api\ProjectDevStageController;
use App\Http\Controllers\Api\ProjectTaskController;
use App\Http\Controllers\Project\ProjectUserController;
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
        Route::get('users',[ProjectUserController::class,'index']);
        Route::get('{ref}',[ProjectController::class,'show']);
        Route::patch('{project}',[ProjectController::class,'update']);
        Route::get('{project}/tasks',[ProjectTaskController::class,'index']);
        Route::post('{project}/tasks',[ProjectTaskController::class,'store']);
    });

    Route::prefix('projects-dev-stages')->group(function () {
        Route::get('',[ProjectDevStageController::class,'index']);
    });


});
