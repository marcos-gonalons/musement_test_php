<?php

namespace App\Service\Api\Musement\CitiesAPI\Entities;

class Country
{

    private ?int $id = null;
    private ?string $name = null;
    private ?string $isoCode = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): Country
    {
        $this->id = $id;
        return $this;
    }


    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): Country
    {
        $this->name = $name;
        return $this;
    }


    public function getIsoCode(): ?string
    {
        return $this->isoCode;
    }

    public function setIsoCode(string $isoCode): Country
    {
        $this->isoCode = $isoCode;
        return $this;
    }
}
