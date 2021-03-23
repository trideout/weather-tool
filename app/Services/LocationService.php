<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class LocationService{
    /**
     * Fetch and return the lat/long data from freegeoip. Optimal implementation would have custom error handlers.
     * Though simple, the abstraction of having location using it's own class allows for alternatives to be easily implemented.
     * @param string $ip
     * @return array
     */
    public function getLocation(string $ip): array{
        $response = Http::get('https://freegeoip.app/json/' . $ip)->json();

        return [
            'latitude' => $response['latitude'],
            'longitude' => $response['longitude'],
        ];
    }
}
