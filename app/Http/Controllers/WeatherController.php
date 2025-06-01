<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WeatherService;

class WeatherController extends Controller
{
    protected $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function index(Request $request)
    {
        // Get location from request (query, body, or 'query' param)
        $location = $request->input('location')
            ?? $request->query('location')
            ?? $request->input('query')
            ?? $request->query('query');

        if (empty($location)) {
            return response()->json([
                'status' => 400,
                'error' => 'Location parameter is required.'
            ], 400);
        }

        $weatherData = $this->weatherService->getWeather($location);

        return response()->json($weatherData);
    }
}
