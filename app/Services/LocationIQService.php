<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class LocationIQService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = Config::get('services.locationiq.key');
        $this->baseUrl = Config::get('services.locationiq.base_url', 'https://us1.locationiq.com/v1');

        if (empty($this->apiKey)) {
            Log::error('LocationIQ API key is not set');
            throw new \Exception('LocationIQ API key is not set in configuration');
        }
    }

    /**
     * Geocode an address using LocationIQ API.
     *
     * @param string|null $address
     * @return array
     */
    public function geocode(?string $address): array
    {
        if (empty($address)) {
            Log::warning('Empty address provided to geocoding service');
            return [
                'status' => 400,
                'error' => 'Address is required',
            ];
        }

        try {
            Log::info('Attempting to geocode address: ' . $address);
            Log::info('Using API key: ' . substr($this->apiKey, 0, 5) . '...');
            
            $response = Http::get($this->baseUrl . '/search.php', [
                'key' => $this->apiKey,
                'q' => $address,
                'format' => 'json',
                'limit' => 1,
                'addressdetails' => 1
            ]);

            Log::info('LocationIQ Response Status: ' . $response->status());
            
            if ($response->successful()) {
                $data = $response->json();
                if (!empty($data)) {
                    return $data;
                }
            }

            Log::error('LocationIQ Error Response: ' . $response->body());
            return [
                'status' => $response->status(),
                'error' => 'Error from LocationIQ: ' . $response->body(),
            ];
        } catch (\Exception $e) {
            Log::error('LocationIQ Service Error: ' . $e->getMessage());
            return [
                'status' => 500,
                'error' => 'Server error: ' . $e->getMessage(),
            ];
        }
    }
}
