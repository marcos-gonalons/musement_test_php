<?php

namespace App\Service\Api\Weather\Entities;

class Forecast
{

    /** @var ForecastDay[] */
    private ?array $forecastDay = null;


    /** @return ForecastDay[] */
    public function getForecastDay(): ?array
    {
        return $this->forecastDay;
    }

    /** @param ForecastDay[] $forecastDay */
    public function setForecastDay(array $forecastDay): Forecast
    {
        $this->forecastDay = $forecastDay;
        return $this;
    }
}
