<?php

namespace App\Service\Api\Musement\CitiesAPI\ResponseValidator;

use App\Service\Api\BaseResponseValidatorInterface;
use App\Service\Api\Musement\CitiesAPI\Entities\City;

interface ResponseValidatorInterface extends BaseResponseValidatorInterface
{
    /** @param City[] $cities */
    public function areCitiesOK(array $cities): bool;
}
