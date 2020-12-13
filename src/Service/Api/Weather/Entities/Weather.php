<?php

namespace App\Service\Api\Weather\Entities;

class Weather
{

    private ?Location $location = null;
    private ?Forecast $forecast = null;

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(Location $location): Weather
    {
        $this->location = $location;
        return $this;
    }

    public function getForecast(): ?Forecast
    {
        return $this->forecast;
    }

    public function setForecast(Forecast $forecast): Weather
    {
        $this->forecast = $forecast;
        return $this;
    }
}
