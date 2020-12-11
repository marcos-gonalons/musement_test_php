<?php

namespace App\Tests\Command;

use App\Service\Forecast\ForecastServiceInterface;
use Prophecy\Argument\Token\AnyValuesToken;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class ForecastCommandTest extends KernelTestCase
{

    use ProphecyTrait;

    private ObjectProphecy $forecastServiceMock;

    public function testExecuteDisplaysErrorOnException()
    {
        $command = $this->getCommand();

        $this->forecastServiceMock->processForecasts(
            new AnyValuesToken()
        )->willThrow(new \Exception("Test error"));

        $command->execute([]);

        $output = $command->getDisplay();
        $this->assertStringContainsString("An error occurred -> Test error", $output);
    }


    public function testExecuteSuccess()
    {
        $command = $this->getCommand();

        $this->forecastServiceMock->processForecasts(
            new AnyValuesToken()
        )->shouldBeCalled();

        $command->execute([]);
    }


    private function getCommand(): CommandTester
    {
        $kernel = static::createKernel();
        $kernel->boot();

        $this->forecastServiceMock = $this->prophesize(ForecastServiceInterface::class);

        $kernel->getContainer()->set("App\Service\Forecast\ForecastService", $this->forecastServiceMock->reveal());
        $application = new Application($kernel);

        $command = $application->find("app:get-forecasts");
        $commandTester = new CommandTester($command);

        return $commandTester;
    }
}
