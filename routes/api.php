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


Route::prefix('classifications')->group(function () {
    Route::get('/monthly/{user_id}', [UserClassificationController::class, 'getMonthlyData']);
    Route::get('/today/{user_id}', [UserClassificationController::class, 'getTodayData']);
    Route::get('/week/{user_id}', [UserClassificationController::class, 'getWeekData']);
    Route::get('/summary/{year}/{month}/{user_id}', [UserClassificationController::class, 'getMonthSummary']);
    Route::get('/report/month/{year}/{month}/{user_id}', [UserClassificationController::class, 'getSpecificMonthReport']);
    Route::get('/report/day/{year}/{month}/{day}/{user_id}', [UserClassificationController::class, 'getSpecificDayReport']);
    Route::post('/store-classification', [UserClassificationController::class, 'store'])->middleware(['auth:sanctum']);
    Route::get('/all-user-stats', [UserClassificationController::class, 'allUserStats'])->middleware(['auth:sanctum']);
});




