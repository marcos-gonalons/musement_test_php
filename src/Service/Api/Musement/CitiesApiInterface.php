<?php

namespace Src\Service\Api\Musement\CitiesApi;

use Src\Service\Api\Musement\CitiesApi\Entities\City;

interface CitiesApiInterface
{

    /**
     * @return City[]
     */
    public function getCities(): array;
}
