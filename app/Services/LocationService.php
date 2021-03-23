<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class LocationService{
    /**
     * Fetch and return the lat/long data from freegeoip. Optimal implementation would have custom error handlers.
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
