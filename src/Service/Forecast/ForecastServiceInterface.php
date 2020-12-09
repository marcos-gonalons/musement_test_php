<?php

namespace App\Service\Forecast;

use App\Service\Forecast\Entities\Forecast;
use Symfony\Component\Console\Output\OutputInterface;

interface ForecastServiceInterface
{

    /** @return Forecast[] */
    public function processForecasts(OutputInterface $output): array;
}
