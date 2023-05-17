<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\AuthUserController;
use App\Http\Controllers\Api\Auth\EmailVerificationController;
use App\Http\Controllers\Api\Auth\MagicAuthController;
use App\Http\Controllers\Api\Auth\PasswordResetController;
use App\Http\Controllers\Api\Auth\RefreshTokenController;
use App\Http\Controllers\Api\Company\UserCompanyController;
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

         // Extract each api route into seperate file


Route::prefix('v1')->group(function () {


    Route::prefix('auth')->group(function () {

        Route::prefix('password-reset')->group(function () {
            Route::post('',[PasswordResetController::class,'store'])->name('password_reset');
            Route::post('reset',[PasswordResetController::class,'update']);
        });

        Route::prefix('email')->group(function () {
            Route::post('verify',[EmailVerificationController::class,'update']);
            Route::post('resend',[EmailVerificationController::class,'store']);
        });

        Route::post('register',[AuthController::class,'store']);
        Route::post('login',[AuthController::class,'show'])->name('login');
        Route::post('refresh-token',[RefreshTokenController::class,'update']);

        Route::prefix('magic-login')->group(function () {
            Route::post('',[MagicAuthController::class,'store']);
            Route::post('verify',[MagicAuthController::class,'update']);
        });

        Route::middleware('auth:sanctum')->group(function () {
            Route::get('user', [AuthUserController::class, 'show']);
            Route::post('logout', [AuthController::class,'delete']);
        });

    });


    Route::middleware('auth:sanctum')->group(function () {

        Route::prefix('users/companies')->group(function () {
            Route::post('', [UserCompanyController::class,'store']);
            Route::get('', [UserCompanyController::class,'show']);
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



