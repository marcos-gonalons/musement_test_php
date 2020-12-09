<?php

namespace App\Service\Forecast;

use App\Service\Forecast\Entities\Forecast;

interface ForecastServiceInterface
{

    /** @return Forecast[] */
    public function getAllForecasts(): array;
}
