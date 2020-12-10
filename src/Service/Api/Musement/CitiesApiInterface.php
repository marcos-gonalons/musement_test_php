<?php

namespace App\Service\Api\Musement;

use App\Service\Api\Musement\Entities\City;

interface CitiesApiInterface
{

    /**
     * @return City[]
     */
    public function getCities(): array;
}
