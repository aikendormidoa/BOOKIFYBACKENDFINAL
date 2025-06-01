<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Ticketmaster, Geocodify, WeatherAPI, Pexels, Abstract, and more.
    |
    */

    'ticketmaster' => [
        'key' => env('TICKETMASTER_KEY'),
    ],

    'openweather' => [
        'api_key' => env('OPENWEATHER_API_KEY'),
        'base_url' => env('OPENWEATHER_API_URL', 'https://api.openweathermap.org/data/2.5/weather'),
    ],

    'pexels' => [
        'key' => env('PEXELS_KEY'),
    ],

    'locationiq' => [
        'key' => env('LOCATIONIQ_API_KEY'),
    ],
];