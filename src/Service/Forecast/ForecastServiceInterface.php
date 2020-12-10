<?php

namespace App\Service\Forecast;

use Symfony\Component\Console\Output\OutputInterface;

interface ForecastServiceInterface
{
    public function processForecasts(OutputInterface $output): void;
}
