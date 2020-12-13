<?php

namespace App\Tests\Service\Api\Weather;

use App\Service\Api\Musement\CitiesAPI\Entities\City;
use App\Service\Api\Weather\ResponseValidator\ResponseValidatorInterface;
use App\Service\Api\Weather\WeatherApi;
use GuzzleHttp\ClientInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument\Token\AnyValuesToken;
use Prophecy\Argument\Token\IdenticalValueToken;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class WeatherApiTest extends TestCase
{
    use ProphecyTrait;

    private string $apiKey;
    private string $apiUrl;
    private ObjectProphecy $httpClientMock;
    private ObjectProphecy $responseValidatorMock;

    public function testGetWeatherBadStatus()
    {
        $apiService = $this->getWeatherApiInstance();

        $responseMock = $this->prophesize(ResponseInterface::class);
        $responseMock->getStatusCode(
            new AnyValuesToken()
        )->willReturn(500);

        $this->httpClientMock->request(
            new IdenticalValueToken("GET"),
            new IdenticalValueToken("dummy-url?key=dummy-key&q=1.2%2C3.4&days=2"),
        )->willReturn($responseMock->reveal());

        $city = new City();
        $city->setLatitude(1.2);
        $city->setLongitude(3.4);

        try {
            $apiService->getWeather($city, 2);

            // Should never execute this
            $this->assertTrue(false);
        } catch (\Throwable $e) {
            $this->assertEquals("Bad response from API -> 500", $e->getMessage());
        }
    }

    public function testGetWeatherBadResponseBody()
    {
        $apiService = $this->getWeatherApiInstance();

        $responseMock = $this->prophesize(ResponseInterface::class);
        $responseMock->getStatusCode(
            new AnyValuesToken()
        )->willReturn(200);

        $responseBodyMock = $this->prophesize(StreamInterface::class);
        $responseBodyMock->getContents(
            new AnyValuesToken()
        )->willReturn("{bad json");
        $responseMock->getBody(
            new AnyValuesToken()
        )->willReturn($responseBodyMock);

        $this->httpClientMock->request(
            new IdenticalValueToken("GET"),
            new IdenticalValueToken("dummy-url?key=dummy-key&q=1.2%2C3.4&days=2"),
        )->willReturn($responseMock->reveal());

        $city = new City();
        $city->setLatitude(1.2);
        $city->setLongitude(3.4);

        try {
            $apiService->getWeather($city, 2);

            // Should never execute this
            $this->assertTrue(false);
        } catch (\Throwable $e) {
            $this->assertEquals("An error happened while mapping the response body -> json_decode error: Syntax error", $e->getMessage());
        }
    }


    public function testGetWeatherErrorWhileValidatingResponse()
    {

        $apiService = $this->getWeatherApiInstance();

        $responseMock = $this->prophesize(ResponseInterface::class);
        $responseMock->getStatusCode(
            new AnyValuesToken()
        )->willReturn(200);

        $responseBodyMock = $this->prophesize(StreamInterface::class);
        $responseBodyMock->getContents(
            new AnyValuesToken()
        )->willReturn($this->getWeatherResponseString());
        $responseMock->getBody(
            new AnyValuesToken()
        )->willReturn($responseBodyMock);

        $this->httpClientMock->request(
            new IdenticalValueToken("GET"),
            new IdenticalValueToken("dummy-url?key=dummy-key&q=1.2%2C3.4&days=2"),
        )->willReturn($responseMock->reveal());

        $this->responseValidatorMock->isWeatherValid(
            new AnyValuesToken()
        )->willReturn(true);


        $this->responseValidatorMock->isWeatherValid(
            new AnyValuesToken()
        )->willReturn(false);

        $validationException = new \Exception("Test error");
        $this->responseValidatorMock->getValidationError(
            new AnyValuesToken()
        )->willReturn($validationException);

        $city = new City();
        $city->setLatitude(1.2);
        $city->setLongitude(3.4);

        try {
            $apiService->getWeather($city, 2);

            // Should never execute this
            $this->assertTrue(false);
        } catch (\Throwable $e) {
            $this->assertEquals("An error happened while mapping the response body -> Test error", $e->getMessage());
        }
    }



    public function testGetWeatherUnknownErrorWhileValidatingResponse()
    {

        $apiService = $this->getWeatherApiInstance();

        $responseMock = $this->prophesize(ResponseInterface::class);
        $responseMock->getStatusCode(
            new AnyValuesToken()
        )->willReturn(200);

        $responseBodyMock = $this->prophesize(StreamInterface::class);
        $responseBodyMock->getContents(
            new AnyValuesToken()
        )->willReturn($this->getWeatherResponseString());
        $responseMock->getBody(
            new AnyValuesToken()
        )->willReturn($responseBodyMock);

        $this->httpClientMock->request(
            new IdenticalValueToken("GET"),
            new IdenticalValueToken("dummy-url?key=dummy-key&q=1.2%2C3.4&days=2"),
        )->willReturn($responseMock->reveal());

        $this->responseValidatorMock->isWeatherValid(
            new AnyValuesToken()
        )->willReturn(true);


        $this->responseValidatorMock->isWeatherValid(
            new AnyValuesToken()
        )->willReturn(false);

        $this->responseValidatorMock->getValidationError(
            new AnyValuesToken()
        )->willReturn(null);

        $city = new City();
        $city->setLatitude(1.2);
        $city->setLongitude(3.4);

        try {
            $apiService->getWeather($city, 2);

            // Should never execute this
            $this->assertTrue(false);
        } catch (\Throwable $e) {
            $this->assertEquals("An error happened while mapping the response body -> Unknown error when validating the get weather response.", $e->getMessage());
        }
    }


    public function testGetWeatherSuccess()
    {
        $apiService = $this->getWeatherApiInstance();

        $responseMock = $this->prophesize(ResponseInterface::class);
        $responseMock->getStatusCode(
            new AnyValuesToken()
        )->willReturn(200);

        $responseBodyMock = $this->prophesize(StreamInterface::class);
        $responseBodyMock->getContents(
            new AnyValuesToken()
        )->willReturn($this->getWeatherResponseString());
        $responseMock->getBody(
            new AnyValuesToken()
        )->willReturn($responseBodyMock);

        $this->httpClientMock->request(
            new IdenticalValueToken("GET"),
            new IdenticalValueToken("dummy-url?key=dummy-key&q=1.2%2C3.4&days=2"),
        )->willReturn($responseMock->reveal());

        $this->responseValidatorMock->isWeatherValid(
            new AnyValuesToken()
        )->willReturn(true);

        $city = new City();
        $city->setLatitude(1.2);
        $city->setLongitude(3.4);

        $weather = $apiService->getWeather($city, 2);

        $this->assertEquals("Test location name", $weather->getLocation()->getName());
        $this->assertEquals("Test location region", $weather->getLocation()->getRegion());
        $this->assertEquals("Test location country", $weather->getLocation()->getCountry());
        $this->assertEquals(1.2, $weather->getLocation()->getLatitude());
        $this->assertEquals(3.4, $weather->getLocation()->getLongitude());
        $this->assertEquals("Test location timezone", $weather->getLocation()->getTimezone());
        $this->assertEquals(123, $weather->getLocation()->getLocaltimeEpoch());
        $this->assertEquals("Test location local time", $weather->getLocation()->getLocaltime());
        $this->assertEquals("12/34/56", $weather->getForecast()->getForecastDay()[0]->getDate());
        $this->assertEquals("1234567890", $weather->getForecast()->getForecastDay()[0]->getDateEpoch());
        $this->assertEquals("Test condition text", $weather->getForecast()->getForecastDay()[0]->getDay()->getCondition()->getText());
        $this->assertEquals("Test condition icon", $weather->getForecast()->getForecastDay()[0]->getDay()->getCondition()->getIcon());
        $this->assertEquals(99, $weather->getForecast()->getForecastDay()[0]->getDay()->getCondition()->getCode());
        $this->assertEquals(11.11, $weather->getForecast()->getForecastDay()[0]->getDay()->getMaxTempC());
        $this->assertEquals(22.22, $weather->getForecast()->getForecastDay()[0]->getDay()->getMaxTempF());
        $this->assertEquals(33.33, $weather->getForecast()->getForecastDay()[0]->getDay()->getMinTempC());
        $this->assertEquals(44.44, $weather->getForecast()->getForecastDay()[0]->getDay()->getMinTempF());
        $this->assertEquals(55.55, $weather->getForecast()->getForecastDay()[0]->getDay()->getAvgTempC());
        $this->assertEquals(66.66, $weather->getForecast()->getForecastDay()[0]->getDay()->getAvgTempF());
        $this->assertEquals(77.77, $weather->getForecast()->getForecastDay()[0]->getDay()->getMaxWindMph());
        $this->assertEquals(88.88, $weather->getForecast()->getForecastDay()[0]->getDay()->getMaxWindKph());
        $this->assertEquals(99.99, $weather->getForecast()->getForecastDay()[0]->getDay()->getTotalPrecipMm());
        $this->assertEquals(100.100, $weather->getForecast()->getForecastDay()[0]->getDay()->getTotalPrecipIn());
        $this->assertEquals(101.101, $weather->getForecast()->getForecastDay()[0]->getDay()->getAvgVisKm());
        $this->assertEquals(102.102, $weather->getForecast()->getForecastDay()[0]->getDay()->getAvgVisMiles());
        $this->assertEquals(103.103, $weather->getForecast()->getForecastDay()[0]->getDay()->getAvgHumidity());
        $this->assertEquals(104.104, $weather->getForecast()->getForecastDay()[0]->getDay()->getDailyWillItRain());
        $this->assertEquals(105.105, $weather->getForecast()->getForecastDay()[0]->getDay()->getDailyChanceOfRain());
        $this->assertEquals(106.106, $weather->getForecast()->getForecastDay()[0]->getDay()->getDailyWillItSnow());
        $this->assertEquals(107.107, $weather->getForecast()->getForecastDay()[0]->getDay()->getDailyChanceOfSnow());
        $this->assertEquals(108.108, $weather->getForecast()->getForecastDay()[0]->getDay()->getUv());
    }


    private function getWeatherResponseString(): string
    {
        $weather = new \StdClass();
        $weather->location = new \StdClass();
        $weather->location->name = "Test location name";
        $weather->location->region = "Test location region";
        $weather->location->country = "Test location country";
        $weather->location->latitude = 1.2;
        $weather->location->longitude = 3.4;
        $weather->location->timezone = "Test location timezone";
        $weather->location->localtimeEpoch = 123;
        $weather->location->localtime = "Test location local time";
        $weather->forecast = new \stdClass();
        $weather->forecast->forecastDay = [new \StdCLass()];
        $weather->forecast->forecastDay[0]->date = "12/34/56";
        $weather->forecast->forecastDay[0]->dateEpoch = "1234567890";
        $weather->forecast->forecastDay[0]->day = new \StdClass();
        $weather->forecast->forecastDay[0]->day->condition = new \StdClass();
        $weather->forecast->forecastDay[0]->day->condition->text = "Test condition text";
        $weather->forecast->forecastDay[0]->day->condition->icon = "Test condition icon";
        $weather->forecast->forecastDay[0]->day->condition->code = 99;
        $weather->forecast->forecastDay[0]->day->maxTempC = 11.11;
        $weather->forecast->forecastDay[0]->day->maxTempF = 22.22;
        $weather->forecast->forecastDay[0]->day->minTempC = 33.33;
        $weather->forecast->forecastDay[0]->day->minTempF = 44.44;
        $weather->forecast->forecastDay[0]->day->avgTempC = 55.55;
        $weather->forecast->forecastDay[0]->day->avgTempF = 66.66;
        $weather->forecast->forecastDay[0]->day->maxWindMph = 77.77;
        $weather->forecast->forecastDay[0]->day->maxWindKph = 88.88;
        $weather->forecast->forecastDay[0]->day->totalPrecipMm = 99.99;
        $weather->forecast->forecastDay[0]->day->totalPrecipIn = 100.100;
        $weather->forecast->forecastDay[0]->day->avgVisKm = 101.101;
        $weather->forecast->forecastDay[0]->day->avgVisMiles = 102.102;
        $weather->forecast->forecastDay[0]->day->avgHumidity = 103.103;
        $weather->forecast->forecastDay[0]->day->dailyWillItRain = 104.104;
        $weather->forecast->forecastDay[0]->day->dailyChanceOfRain = 105.105;
        $weather->forecast->forecastDay[0]->day->dailyWillItSnow = 106.106;
        $weather->forecast->forecastDay[0]->day->dailyChanceOfSnow = 107.107;
        $weather->forecast->forecastDay[0]->day->uv = 108.108;

        return json_encode($weather);
    }

    private function getWeatherApiInstance(): WeatherApi
    {
        $this->apiKey = "dummy-key";
        $this->apiUrl = "dummy-url";
        $this->httpClientMock = $this->prophesize(ClientInterface::class);
        $this->responseValidatorMock = $this->prophesize(ResponseValidatorInterface::class);
        return new WeatherApi(
            $this->apiKey,
            $this->apiUrl,
            $this->httpClientMock->reveal(),
            $this->responseValidatorMock->reveal()
        );
    }
}
