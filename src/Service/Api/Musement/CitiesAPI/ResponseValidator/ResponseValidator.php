<?php

namespace App\Service\Api\Musement\CitiesAPI\ResponseValidator;

use App\Service\Api\BaseResponseValidator;
use App\Service\Api\Musement\CitiesAPI\Entities\City;

class ResponseValidator extends BaseResponseValidator implements ResponseValidatorInterface
{

    /** @param City[] $cities */
    public function areCitiesOK(array $cities): bool
    {
        foreach ($cities as $index => $city) {
            if (!$city->getName()) {
                $this->validationError = new \Exception("City in position $index does not have a name.");
                return false;
            }
            if ($city->getLongitude() === null) {
                $this->validationError = new \Exception("City in position $index does not have longitude.");
                return false;
            }
            if ($city->getLatitude() === null) {
                $this->validationError = new \Exception("City in position $index does not have latitude.");
                return false;
            }
            /** Add more validations here as needed. */
        }
        return true;
    }
}
