<?php

namespace App\Tests\Service\Api\Weather\ResponseValidator;

use App\Service\Api\Weather\Entities\Condition;
use App\Service\Api\Weather\Entities\Day;
use App\Service\Api\Weather\Entities\Forecast;
use App\Service\Api\Weather\Entities\ForecastDay;
use App\Service\Api\Weather\Entities\Weather;
use App\Service\Api\Weather\ResponseValidator\ResponseValidator;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class ResponseValidatorTest extends TestCase
{

    use ProphecyTrait;

    public function testEmptyForecastObject()
    {
        $validator = $this->getResonseValidatorInstance();

        $weather = new Weather();
        $result = $validator->isWeatherValid($weather);

        $this->assertEquals(false, $result);

        /** @var \Throwable $error */
        $error = $validator->getValidationError();
        $this->assertEquals("Weather object does not contain Forecast object.", $error->getMessage());
    }


    public function testForecastDaysIsNull()
    {
        $validator = $this->getResonseValidatorInstance();

        $weather = new Weather();
        $forecast = new Forecast();
        $weather->setForecast($forecast);
        $result = $validator->isWeatherValid($weather);

        $this->assertEquals(false, $result);

        /** @var \Throwable $error */
        $error = $validator->getValidationError();
        $this->assertEquals("Forecast object does not contain the forecast days array.", $error->getMessage());
    }


    public function testEmptyForecastDaysArray()
    {
        $validator = $this->getResonseValidatorInstance();

        $weather = new Weather();
        $forecast = new Forecast();
        $forecast->setForecastDay([]);
        $weather->setForecast($forecast);
        $result = $validator->isWeatherValid($weather);

        $this->assertEquals(false, $result);

        /** @var \Throwable $error */
        $error = $validator->getValidationError();
        $this->assertEquals("Forecast object does not contain the forecast days array.", $error->getMessage());
    }


    public function testEmptyDayObject()
    {
        $validator = $this->getResonseValidatorInstance();

        $weather = new Weather();
        $forecast = new Forecast();
        $forecastDay = new ForecastDay();
        $forecast->setForecastDay([$forecastDay]);
        $weather->setForecast($forecast);
        $result = $validator->isWeatherValid($weather);

        $this->assertEquals(false, $result);

        /** @var \Throwable $error */
        $error = $validator->getValidationError();
        $this->assertEquals("Forecast day at position 0 does not contain the Day object.", $error->getMessage());
    }


    public function testEmptyConditionObject()
    {
        $validator = $this->getResonseValidatorInstance();

        $weather = new Weather();
        $forecast = new Forecast();
        $forecastDay = new ForecastDay();
        $day = new Day();
        $forecastDay->setDay($day);
        $forecast->setForecastDay([$forecastDay]);
        $weather->setForecast($forecast);
        $result = $validator->isWeatherValid($weather);

        $this->assertEquals(false, $result);

        /** @var \Throwable $error */
        $error = $validator->getValidationError();
        $this->assertEquals("Day object at position 0 of the forecast days array does not contain the Condition object.", $error->getMessage());
    }


    public function testEmptyConditionText()
    {
        $validator = $this->getResonseValidatorInstance();

        $weather = new Weather();
        $forecast = new Forecast();
        $forecastDay = new ForecastDay();
        $day = new Day();
        $condition = new Condition();
        $day->setCondition($condition);
        $forecastDay->setDay($day);
        $forecast->setForecastDay([$forecastDay]);
        $weather->setForecast($forecast);
        $result = $validator->isWeatherValid($weather);

        $this->assertEquals(false, $result);

        /** @var \Throwable $error */
        $error = $validator->getValidationError();
        $this->assertEquals("Condition object at position 0 of the forecast days array is empty.", $error->getMessage());
    }


    public function testValidationsSuccess()
    {
        $validator = $this->getResonseValidatorInstance();

        $weather = new Weather();
        $forecast = new Forecast();
        $forecastDay = new ForecastDay();
        $day = new Day();
        $condition = new Condition();
        $condition->setText("Test condition");
        $day->setCondition($condition);
        $forecastDay->setDay($day);
        $forecast->setForecastDay([$forecastDay]);
        $weather->setForecast($forecast);

        $result = $validator->isWeatherValid($weather);
        $this->assertEquals(true, $result);

        $error = $validator->getValidationError();
        $this->assertEquals(null, $error);
    }



    private function getResonseValidatorInstance(): ResponseValidator
    {
        return new ResponseValidator();
    }
}
