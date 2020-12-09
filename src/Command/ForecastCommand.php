<?php

namespace App\Command;

use App\Service\Forecast\ForecastServiceInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ForecastCommand extends Command
{

    protected static $defaultName = "app:get-forecasts";

    private ForecastServiceInterface $forecastService;


    public function __construct(ForecastServiceInterface $forecastService)
    {
        $this->forecastService = $forecastService;
        parent::__construct();
    }


    protected function configure(): void
    {
        $this->setDescription("Prints the list of cities with the weather forecast for today and tomorrow");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $forecasts = $this->forecastService->getAllForecasts();
            var_dump($forecasts);
            return Command::SUCCESS;
        } catch (\Throwable $e) {
            $output->writeln("An error occurred -> " . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
