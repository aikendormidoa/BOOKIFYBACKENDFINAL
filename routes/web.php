<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\EmailController;

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
});