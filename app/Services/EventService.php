<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EventService
{
    protected $apiKey;
    protected $apiUrl = 'https://app.ticketmaster.com/discovery/v2/events.json';

    public function __construct()
    {
        $this->apiKey = config('services.ticketmaster.key');
    }

    public function fetchEvents($query = 'music')
    {
        try {
            $response = Http::get($this->apiUrl, [
                'keyword' => $query,
                'apikey'  => $this->apiKey,
            ]);
            return $response->json();
        } catch (\Exception $e) {
            Log::error('Ticketmaster API error: ' . $e->getMessage());
            return ['error' => 'Unable to fetch events.'];
        }
    }
}