<?php

namespace App\Service\Forecast;

use App\Service\Api\Musement\CitiesApiInterface;
use App\Service\Api\Weather\WeatherApiInterface;
use App\Service\Forecast\Entities\Forecast;
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


    /** @return Forecast[] */
    public function processForecasts(OutputInterface $output): array
    {
        $cities = $this->citiesApi->getCities();

        $forecastArr = [];
        foreach ($cities as $city) {
            // https://www.geeksforgeeks.org/how-to-make-asynchronous-http-requests-in-php/

            $cityWeather = $this->weatherApi->getWeather($city, static::FORECAST_DAYS);

            $forecast = new Forecast();
            $forecast->setCity($city);
            $forecast->setToday($cityWeather->getForecast()->getForecastDay()[0]->getDay());
            $forecast->setTomorrow($cityWeather->getForecast()->getForecastDay()[1]->getDay());

            $forecastArr[] = $forecast;

            $output->writeln("" .
                "Processed city " . $forecast->getCity()->getName() . " | " .
                $forecast->getToday()->getCondition()->getText() . " - " .
                $forecast->getTomorrow()->getCondition()->getText() .
                "");
        }

        return $forecastArr;
    }
}
