<?php

namespace App\Service\Forecast;

use App\Service\Api\Musement\CitiesAPI\CitiesApiInterface;
use App\Service\Api\Weather\Entities\Condition;
use App\Service\Api\Weather\Entities\Day;
use App\Service\Api\Weather\Entities\Forecast;
use App\Service\Api\Weather\Entities\ForecastDay;
use App\Service\Api\Weather\Entities\Weather;
use App\Service\Api\Weather\WeatherApiInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ForecastService implements ForecastServiceInterface
{

    private const FORECAST_DAYS = 2;

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
            [$conditionToday, $conditionTomorrow] = $this->getWeatherConditions($weather);
            $output->writeln("Processed city {$city->getName()} | $conditionToday - $conditionTomorrow");
        }
    }

    /** @return string[] */
    private function getWeatherConditions(Weather $weather): array
    {
        /** @var Forecast $forecast */
        $forecast = $weather->getForecast();

        /** @var string[] $conditions */
        $conditions = [];

        /** @var ForecastDay[] $forecastDays */
        $forecastDays = $forecast->getForecastDay();
        foreach ($forecastDays as $forecastDay) {
            /** @var Day $day */
            $day = $forecastDay->getDay();

            /** @var Condition $condition */
            $condition = $day->getCondition();

            $conditions[] = $condition->getText() ?? "Unknown";
        }

        return $conditions;
    }
}
