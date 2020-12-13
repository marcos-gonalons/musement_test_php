<?php

namespace App\Service\Api\Weather\ResponseValidator;

use App\Service\Api\BaseResponseValidator;
use App\Service\Api\Weather\Entities\Weather;

class ResponseValidator extends BaseResponseValidator implements ResponseValidatorInterface
{

    /** @param Weather $weather */
    public function isWeatherValid(Weather $weather): bool
    {
        if ($weather->getForecast() === null) {
            $this->validationError = new \Exception("Weather object does not contain Forecast object.");
            return false;
        }

        $forecastDays = $weather->getForecast()->getForecastDay();
        if ($forecastDays === null || count($forecastDays) === 0) {
            $this->validationError = new \Exception("Forecast object does not contain the forecast days array.");
            return false;
        }

        foreach ($forecastDays as $index => $forecastDay) {
            if ($forecastDay->getDay() === null) {
                $this->validationError = new \Exception("" .
                    "Forecast day at position $index does not contain the Day object." .
                    "");
                return false;
            }
            if ($forecastDay->getDay()->getCondition() === null) {
                $this->validationError = new \Exception("" .
                    "Day object at position $index of the forecast days array does not contain the Condition object." .
                    "");
                return false;
            }
            if ($forecastDay->getDay()->getCondition()->getText() === null) {
                $this->validationError = new \Exception("" .
                    "Condition object at position $index of the forecast days array is empty." .
                    "");
                return false;
            }
        }

        /** Add more validations here as needed. */
        return true;
    }
}
