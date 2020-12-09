<?php

namespace Src\Service\Forecast;

use Src\Service\Api\Musement\CitiesApi\CitiesApiInterface;
use Src\Service\Api\Weather\WeatherApi\WeatherApiInterface;

class ForecastService implements ForecastServiceInterface
{

    private CitiesApiInterface $citiesApi;
    private WeatherApiInterface $weatherApi;

    public function __construct(
        CitiesApiInterface $citiesApi,
        WeatherApiInterface $weatherApi
    ) {
        $this->citiesApi = $citiesApi;
        $this->weatherApi = $weatherApi;
    }
}
