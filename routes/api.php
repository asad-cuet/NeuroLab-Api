<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\Auth\AuthCenterController;
use App\Http\Controllers\Api\V1\Auth\PasswordAuthController;
use App\Http\Controllers\Api\V1\Auth\OtpAuthController;
use App\Http\Controllers\Api\V1\Auth\SocialAuthController;
use App\Http\Controllers\Api\V1\Auth\BreezeCustomController;
use App\Http\Controllers\Api\V1\Auth\AccountController;


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

Route::middleware(['auth:sanctum','verified'])->get('/user', function (Request $request) {
    return $request->user();
});
//Signup
Route::group(['prefix' => 'v1'], function () {

    Route::group(['prefix' => '/auth'], function () {

        Route::controller(AuthCenterController::class)->group(function () {
            Route::post('/signup/{provider?}', 'signUp');
            Route::post('/signin/{provider?}', 'signIn');

            Route::middleware('auth:sanctum')->group(function () {
                Route::get('/signout', 'signOut');
            });
        });


        if(env('AUTH_PHONE_SUPPORT'))
        {
            Route::controller(OtpAuthController::class)->group(function () {
                Route::post('/send-signup-otp', 'sendSignUpOtp');
                Route::post('/send-signin-otp', 'sendSignInOtp');
                Route::post('/send-reset-otp', 'sendResetOtp');
                Route::post('/verify-reset-otp', 'verifyResetOtp');
                Route::post('/otp-reset-password-app', 'resetPassword');
            });

            Route::controller(BreezeCustomController::class)->group(function () {
                Route::post('/otp-signin-web', 'signIn');
                Route::post('/otp-reset-password-web', 'resetPassword');
            });
        }



        Route::controller(SocialAuthController::class)->group(function () {
            Route::post('/social-signin-via-access-token', 'signInByAccessToken');
            Route::get('/social-signin-via-redirect/{provider}', 'signInByRedirect');
            Route::post('/social-signin/{provider}/callback', 'handleProviderCallback');
            Route::get('/social-signin/{provider}/callback', 'handleProviderCallback');
        });

        Route::controller(AccountController::class)
            ->middleware('auth:sanctum')
            ->group(function () {
                Route::post('/profile-update', 'profileAccountUpdate');
                Route::post('/change-password', 'changePassword');
        });
    });

    Route::controller(\App\Http\Controllers\Api\V1\DevApiController::class)->group(function () {
        Route::get('/create-token/{user_id}', 'createToken');
    });

    
    Route::apiResource('users', 'App\Http\Controllers\Api\V1\UserController')->middleware('auth:sanctum','verified');

    Route::apiResource('blog-categories', 'App\Http\Controllers\Api\V1\BlogCategoryController')->only(['index','show']);
        
    Route::apiResource('blogs', 'App\Http\Controllers\Api\V1\BlogController')->only(['index','show']);
    Route::get('blogs-trending-tags', 'App\Http\Controllers\Api\V1\BlogController@blogTrendingTags');
        
    Route::apiResource('blog-comments', 'App\Http\Controllers\Api\V1\BlogCommentController')->only(['index','show']);

    Route::apiResource('pages', 'App\Http\Controllers\Api\V1\PageController');

    
    //DYNAMIC_API

});




