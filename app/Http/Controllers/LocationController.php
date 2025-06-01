<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\LocationIQService;
use Illuminate\Support\Facades\Http;

class LocationController extends Controller
{
    protected LocationIQService $locationIQ;

    public function __construct(LocationIQService $locationIQ)
    {
        $this->locationIQ = $locationIQ;
    }

    /**
     * Geocode an address using LocationIQ.
     *
     * @param Request $request
     * @param string|null $address
     * @return JsonResponse
     */
    public function geocode(Request $request, string $address = null): JsonResponse
    {
        $address = $address
            ?? $request->query('address')
            ?? $request->input('address');

        return response()->json(
            $this->locationIQ->geocode($address)
        );
    }

    /**
     * Get the weather for a given latitude and longitude.
     *
     * @param float $lat
     * @param float $lon
     * @return array
     */
    public function getWeather($lat, $lon)
    {
        $apiKey = config('services.weatherapi.key');
        $url = 'http://api.weatherapi.com/v1/current.json';
        $response = Http::get($url, [
            'key' => $apiKey,
            'q' => "{$lat},{$lon}",
        ]);
        return $response->json();
    }
}
