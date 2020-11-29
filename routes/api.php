<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegistrationController;
use App\Http\Controllers\Api\Auth\Social\FacebookSocialController;
use App\Http\Controllers\Api\Auth\Social\GoogleSocialController;
use App\Http\Controllers\Api\Auth\UserController;
use App\Http\Controllers\Api\User\UpcomingEventsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('/register', [RegistrationController::class, 'register'])->name('register');
    Route::post('/login', [LoginController::class, 'login'])->name('login');

    Route::get('/login/google', [GoogleSocialController::class, 'redirectToProvider']);
    Route::get('/login/google/callback', [GoogleSocialController::class, 'handleProviderCallback']);
    Route::get('/login/facebook', [FacebookSocialController::class, 'redirectToProvider']);
    Route::get('/login/facebook/callback', [FacebookSocialController::class, 'handleProviderCallback']);

    Route::get('/user', [UserController::class, 'show'])->name('user.show')->middleware('auth:api');
});

Route::middleware('auth:api')->group(function () {
    Route::get('/me/upcoming-events', [UpcomingEventsController::class, 'index']);
});
