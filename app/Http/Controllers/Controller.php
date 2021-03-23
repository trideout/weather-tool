<?php

namespace App\Http\Controllers;

use App\Services\LocationService;
use App\Services\WeatherService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var LocationService
     */
    private $locationService;
    /**
     * @var WeatherService
     */
    private $weatherService;

    public function __construct(){
        $this->locationService = new LocationService();
        $this->weatherService = new WeatherService();
    }

    /**
     * Validation and data fetching for weather lookup requests. Only handles one request type. If handling multiple request types I would use a custom factory instead.
     *
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function lookUpWeather(): JsonResponse{
        /**
         * validation here will return a 422 error allowing for additional user interaction
         */
        $this->validate(request(), [
            'ip_address' => 'required|ip',
        ]);
        /**
         * location lookup and weather lookup are broken into separate services to provide abstraction.
         * a first class project would treat these as interfaces.
         */
        $ip = request()->get('ip_address');
        $location = $this->locationService->getLocation($ip);
        $weather = $this->weatherService->getWeather($location);
        return response()->json($weather);
    }
}
