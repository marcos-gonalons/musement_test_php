<?php

namespace App\Service\Api\Weather\ResponseValidator;

use App\Service\Api\BaseResponseValidatorInterface;
use App\Service\Api\Weather\Entities\Weather;

interface ResponseValidatorInterface extends BaseResponseValidatorInterface
{

    /** @param Weather $weather */
    public function isWeatherValid(Weather $weather): bool;
}
