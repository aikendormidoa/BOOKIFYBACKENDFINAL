<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ImageService
{
    protected $apiKey;
    protected $apiUrl = 'https://api.pexels.com/v1/search';

    public function __construct()
    {
        $this->apiKey = config('services.pexels.key');
        Log::info('ImageService initialized with API Key: ' . $this->apiKey);
    }

    public function searchImages($query = 'events')
    {
        Log::info('Searching images with query: ' . $query);
        try {
            $response = Http::withHeaders([
                'Authorization' => $this->apiKey,
                'Accept' => 'application/json',
            ])->get($this->apiUrl, [
                'query' => $query,
                'per_page' => 10,
            ]);

            Log::info('Pexels Response Status: ' . $response->status());
            Log::info('Pexels Response Body: ' . $response->body());

            if ($response->successful()) {
                $data = $response->json();
                return array_map(function ($photo) {
                    return [
                        'url' => $photo['src']['medium'],
                        'description' => $photo['alt'] ?? 'No description',
                        'user' => $photo['photographer'],
                    ];
                }, $data['photos']);
            }

            return [
                'error' => true,
                'message' => 'Failed to fetch images: ' . $response->body(),
                'status' => $response->status(),
            ];
        } catch (\Exception $e) {
            Log::error('ImageService Error: ' . $e->getMessage());
            return [
                'error' => true,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ];
        }
    }
}