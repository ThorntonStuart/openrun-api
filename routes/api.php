<?php

use App\Http\Controllers\Api\Addresses\AddressesLookupController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegistrationController;
use App\Http\Controllers\Api\Auth\Social\FacebookSocialController;
use App\Http\Controllers\Api\Auth\Social\GoogleSocialController;
use App\Http\Controllers\Api\Auth\UserController;
use App\Http\Controllers\Api\ConfirmEventSlotController;
use App\Http\Controllers\Api\EventsController;
use App\Http\Controllers\Api\Search\UserSearchController;
use App\Http\Controllers\Api\User\ConversationsController;
use App\Http\Controllers\Api\User\MessagesController;
use App\Http\Controllers\Api\User\PaymentMethodsController;
use App\Http\Controllers\Api\User\StripeIntentController;
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

Route::prefix('events')->group(function () {
    Route::get('/{event}', [EventsController::class, 'show']);

    Route::middleware('auth:api')->group(function () {
        Route::post('/{event}/confirm-slot', ConfirmEventSlotController::class);
    });
});

Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('/register', [RegistrationController::class, 'register'])->name('register');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/logout', LogoutController::class)->name('logout');

    Route::get('/login/google', [GoogleSocialController::class, 'redirectToProvider']);
    Route::get('/login/google/callback', [GoogleSocialController::class, 'handleProviderCallback']);
    Route::get('/login/facebook', [FacebookSocialController::class, 'redirectToProvider']);
    Route::get('/login/facebook/callback', [FacebookSocialController::class, 'handleProviderCallback']);

    Route::middleware('auth:api')->group(function () {
        Route::get('/user', [UserController::class, 'show'])->name('user.show');
    });
});

Route::middleware('auth:api')->group(function () {
    Route::prefix('me')->group(function () {
        Route::get('/setup-intent', StripeIntentController::class);
        Route::post('/payment-methods', [PaymentMethodsController::class, 'store']);
        
        Route::get('/upcoming-events', [UpcomingEventsController::class, 'index']);
        Route::get('/conversations', [ConversationsController::class, 'index']);
        Route::get('/conversations/{conversation}', [ConversationsController::class, 'show']);
        
        Route::get('/messages', [MessagesController::class, 'index']);
        Route::post('/messages', [MessagesController::class, 'store']);
    });

    Route::prefix('search')->group(function () {
        Route::post('/users', UserSearchController::class);
    });

    Route::prefix('addresses')->as('addresses.')->group(function () {
        Route::post('/lookup', AddressesLookupController::class)->name('lookup');
    });
});
