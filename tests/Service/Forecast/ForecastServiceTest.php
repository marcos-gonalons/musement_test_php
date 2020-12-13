<?php

namespace App\Tests\Service\Forecast;

use App\Service\Api\Musement\CitiesAPI\CitiesApiInterface;
use App\Service\Api\Musement\CitiesAPI\Entities\City;
use App\Service\Api\Weather\Entities\Condition;
use App\Service\Api\Weather\Entities\Day;
use App\Service\Api\Weather\Entities\Forecast;
use App\Service\Api\Weather\Entities\ForecastDay;
use App\Service\Api\Weather\Entities\Location;
use App\Service\Api\Weather\Entities\Weather;
use App\Service\Api\Weather\WeatherApiInterface;
use App\Service\Forecast\ForecastService;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument\Token\AnyValuesToken;
use Prophecy\Argument\Token\IdenticalValueToken;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\Console\Output\OutputInterface;

class ForecastServiceTest extends TestCase
{

    use ProphecyTrait;

    private ObjectProphecy $citiesApiMock;
    private ObjectProphecy $weatherApiMock;

    public function testProcessForecasts()
    {
        $forecastService = $this->getForecastServiceInstance();

        $city = new City();
        $this->citiesApiMock->getCities(
            new AnyValuesToken()
        )->willReturn([$city]);

        $weather = $this->getMockedWeather("Test city", "Sunny", "Cloudy");

        $this->weatherApiMock->getWeather(
            new IdenticalValueToken($city),
            new IdenticalValueToken(2)
        )->willReturn($weather);


        $outputMock = $this->prophesize(OutputInterface::class);
        $outputMock->writeln(
            new IdenticalValueToken("Processed city Test city | Sunny - Cloudy")
        )->shouldBeCalled();

        $forecastService->processForecasts($outputMock->reveal());
    }


    private function getMockedWeather(string $cityName, string $weatherDay1, string $weatherDay2): Weather
    {
        $location = new Location();
        $location->setName($cityName);

        $forecast = new Forecast();

        $forecastDay1 = new ForecastDay();
        $day1 = new Day();
        $condition1 = new Condition();
        $condition1->setText($weatherDay1);
        $day1->setCondition($condition1);
        $forecastDay1->setDay($day1);


        $forecastDay2 = new ForecastDay();
        $day2 = new Day();
        $condition2 = new Condition();
        $condition2->setText($weatherDay2);
        $day2->setCondition($condition2);
        $forecastDay2->setDay($day2);


        $forecast->setForecastDay([$forecastDay1, $forecastDay2]);

        $weather = new Weather();

        $weather->setLocation($location);
        $weather->setForecast($forecast);

        return $weather;
    }


    private function getForecastServiceInstance(): ForecastService
    {
        $this->citiesApiMock = $this->prophesize(CitiesApiInterface::class);
        $this->weatherApiMock = $this->prophesize(WeatherApiInterface::class);

        return new ForecastService(
            $this->citiesApiMock->reveal(),
            $this->weatherApiMock->reveal()
        );
    }
}
