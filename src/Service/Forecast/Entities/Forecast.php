<?php

namespace App\Service\Forecast\Entities;

use App\Service\Api\Musement\CitiesApi\Entities\City;
use App\Service\Api\Weather\Entities\Day;

class Forecast
{

    private City $city;
    private Day $today;
    private Day $tomorrow;


    public function getCity(): City
    {
        return $this->city;
    }

    public function setCity(City $city): Forecast
    {
        $this->city = $city;
        return $this;
    }


    public function getToday(): Day
    {
        return $this->today;
    }

    public function setToday(Day $today): Forecast
    {
        $this->today = $today;
        return $this;
    }


    public function getTomorrow(): Day
    {
        return $this->tomorrow;
    }

    public function setTomorrow(Day $tomorrow): Forecast
    {
        $this->tomorrow = $tomorrow;
        return $this;
    }
}
