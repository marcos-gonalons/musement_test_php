<?php

namespace App\Service\Api\Musement\CitiesAPI;

use App\Service\Api\Musement\CitiesAPI\Entities\City;

interface CitiesApiInterface
{

    /**
     * @return City[]
     */
    public function getCities(): array;
}
