<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Exception;

class WeatherService
{
    protected Client $client;
    protected string $apiKey;
    protected string $baseUrl;

    public function __construct()
    {
        $this->client = new Client();

        $this->apiKey = config('services.openweather.api_key') ?? env('OPENWEATHER_API_KEY');
        $this->baseUrl = config('services.openweather.base_url') ?? 'https://api.openweathermap.org/data/2.5/weather';

        if (empty($this->apiKey)) {
            throw new Exception('OpenWeather API key is not set in the .env file.');
        }
    }

    /**
     * Get weather data for the requested location.
     *
     * @param string $location
     * @return array
     */
    public function getWeather(string $location): array
    {
        try {
            $response = $this->client->get($this->baseUrl, [
                'query' => [
                    'q' => $location,
                    'appid' => $this->apiKey,
                    'units' => 'metric', // Celsius
                ],
            ]);

            return [
                'location' => $location,
                'weather' => json_decode($response->getBody()->getContents(), true),
            ];
        } catch (RequestException $e) {
            return [
                'error' => true,
                'message' => 'Unable to fetch weather data. Please check the location or try again later.',
            ];
        }
    }
}