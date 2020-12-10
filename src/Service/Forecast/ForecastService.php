<?php

namespace App\Service\Forecast;

use App\Service\Api\Musement\CitiesApiInterface;
use App\Service\Api\Weather\WeatherApiInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ForecastService implements ForecastServiceInterface
{

    const FORECAST_DAYS = 2;

    private CitiesApiInterface $citiesApi;
    private WeatherApiInterface $weatherApi;

    public function __construct(
        CitiesApiInterface $citiesApi,
        WeatherApiInterface $weatherApi
    ) {
        $this->citiesApi = $citiesApi;
        $this->weatherApi = $weatherApi;
    }


    public function processForecasts(OutputInterface $output): void
    {
        $cities = $this->citiesApi->getCities();

        foreach ($cities as $city) {
            $weather = $this->weatherApi->getWeather($city, static::FORECAST_DAYS);
            $output->writeln("" .
                "Processed city " . $weather->getLocation()->getName() . " | " .
                $weather->getForecast()->getForecastDay()[0]->getDay()->getCondition()->getText() . " - " .
                $weather->getForecast()->getForecastDay()[1]->getDay()->getCondition()->getText() .
                "");
        }
    }
}
