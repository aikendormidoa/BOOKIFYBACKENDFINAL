<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\Auth\RegisterController; 

Route::prefix('api')->group(function () {
    // Ticketmaster Events (user query)
    Route::get('/events/{query?}', [EventController::class, 'getEvents']);

    // Geocode (user address query)
    Route::get('/geocode/{address?}', [LocationController::class, 'geocode']);
    Route::post('/geocode', [LocationController::class, 'geocode']);

    // Weather (user location query)
    Route::match(['get', 'post'], '/weather/{query?}', [WeatherController::class, 'index']);

    // Images (user query)
    Route::get('/images/{query?}', [ImageController::class, 'searchImages']);

    // Email validation (user email)
    Route::post('/email/send-confirmation', [EmailController::class, 'sendConfirmation']);

    // User Registration
    Route::post('/register', RegisterController::class)->name('register');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        })->name('user.profile');

        Route::get('/protected-resource', function () {
            return response()->json(['data' => 'This is protected data.']);
        })->name('protected.resource');

        Route::apiResource('users', UserController::class);
    });

});