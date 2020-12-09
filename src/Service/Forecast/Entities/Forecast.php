<?php

namespace Src\Service\Forecast\Entities;

class Forecast
{

    private int $id;


    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Forecast
    {
        $this->id = $id;
        return $this;
    }
}
