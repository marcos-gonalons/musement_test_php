<?php

namespace App\Service\Api\Weather;

use App\Service\Api\Musement\Entities\City;
use App\Service\Api\Weather\Entities\Weather;

interface WeatherApiInterface
{
    public function getWeather(City $city, int $days): Weather;
}
