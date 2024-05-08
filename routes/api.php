<?php

use App\Http\Controllers\Api\Account\AccountController;
use App\Http\Controllers\Api\Account\PasswordUpdateController;
use App\Http\Controllers\Api\Account\ProfilePictureController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\AuthUserController;
use App\Http\Controllers\Api\Auth\EmailVerificationController;
use App\Http\Controllers\Api\Auth\MagicAuthController;
use App\Http\Controllers\Api\Auth\PasswordResetController;
use App\Http\Controllers\Api\Auth\RefreshTokenController;
use App\Http\Controllers\Api\Company\CompanyController;
use App\Http\Controllers\Api\Company\CompanyUserController;
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


Route::prefix('v1')->group(function () {


    Route::prefix('auth')->group(function () {


        Route::prefix('email')->group(function () {
            Route::post('verify',[EmailVerificationController::class,'update']);
            Route::post('resend',[EmailVerificationController::class,'store']);
        });

        Route::post('register',[AuthController::class,'store']);
        Route::post('login',[AuthController::class,'show'])->name('login');

        Route::middleware('auth:sanctum')->group(function () {
            Route::get('user', [AuthUserController::class, 'show']);
            Route::delete('logout', [AuthController::class,'delete']);
        });

    });

});



