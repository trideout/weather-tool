<?php
namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class WeatherService {
    /**
     * Fetch weather fom a location in the format [lat,long]
     * @param array $location
     * @return array
     */
    public function getWeather(array $location): array{
        $lattlong = implode(',', $location);
        $woeId = Http::get('https://www.metaweather.com/api/location/search?lattlong='  . $lattlong)->json()[0]['woeid'];
        $response = Http::get('https://www.metaweather.com/api/location/'. $woeId . '/')->json();
        $weather = [
            'results' => [],
            'locationName' => $response['title'],
            'timezone' => $response['timezone'],
            'sun_rise' => $response['sun_rise'],
            'sun_set' => $response['sun_set'],
            'current' => round(($response['consolidated_weather'][0]['min_temp'] * 9 / 5) + 32),
        ];
        foreach($response['consolidated_weather'] as $row){
            $weather['results'][] = $this->formatDay($row);
        }
        return $weather;
    }

    /**
     * Proxy for response from metaweather to be passed to the decorator
     * @param array $data
     * @return array
     */
    public function formatDay(array $data): array{
        $day = [
            'date' => Carbon::parse($data['applicable_date'])->format('D M j'),
            'image' => 'https://www.metaweather.com/static/img/weather/png/64/' . $data['weather_state_abbr'] . '.png',
            'high' => round(($data['max_temp'] * 9/5) + 32),
            'low' => round(($data['min_temp'] * 9/5) + 32),
            'description' => $data['weather_state_name'],
            'humidity' => $data['humidity'],
            'predictability' => $data['predictability'],
        ];
        return $day;
    }
}
