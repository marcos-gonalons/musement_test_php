<?php

namespace App\Service\Forecast;

use App\Service\Api\Musement\CitiesApiInterface;
use App\Service\Api\Weather\WeatherApiInterface;
use App\Service\Forecast\Entities\Forecast;

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


    /** @return Forecast[] */
    public function getAllForecasts(): array
    {
        $cities = $this->citiesApi->getCities();
        die();
        /**
         * Get cities
         * forecasts = []
         * For each city {
         *     api call and get forecast
         *          Try to do it asynchronosuly
         *          Fetch all at once, and generate the forecast object via callback
         *          With go it would be so easy
         *          https://www.geeksforgeeks.org/how-to-make-asynchronous-http-requests-in-php/
         *     build forecast object with api response
         *     forecasts[] = object
         * }
         * return forecasts
         */
        return [];
    }
}
