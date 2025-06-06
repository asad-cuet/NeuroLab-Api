<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\Auth\AuthCenterController;
use App\Http\Controllers\Api\V1\Auth\PasswordAuthController;
use App\Http\Controllers\Api\V1\Auth\OtpAuthController;
use App\Http\Controllers\Api\V1\Auth\SocialAuthController;
use App\Http\Controllers\Api\V1\Auth\BreezeCustomController;
use App\Http\Controllers\Api\V1\Auth\AccountController;


use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\V1\UserClassificationController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum']);


Route::prefix('classifications')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/monthly', [UserClassificationController::class, 'getMonthlyData']);
    Route::get('/today', [UserClassificationController::class, 'getTodayData']);
    Route::get('/week', [UserClassificationController::class, 'getWeekData']);
    Route::post('/', [UserClassificationController::class, 'addClassification']);
    Route::get('/summary/{year}/{month}', [UserClassificationController::class, 'getMonthSummary']);
    Route::get('/report/month/{year}/{month}', [UserClassificationController::class, 'getSpecificMonthReport']);
    Route::get('/report/day/{year}/{month}/{day}', [UserClassificationController::class, 'getSpecificDayReport']);
});




