<?php

namespace Src\Service\Api\Weather\Entities;

class Location
{

    private string $name;
    private string $region;
    private string $country;
    private float $latitude;
    private float $longitude;
    private string $timezone;
    private int $localtimeEpoch;
    private string $localtime;


    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Location
    {
        $this->name = $name;
        return $this;
    }


    public function getRegion(): string
    {
        return $this->region;
    }

    public function setRegion(string $region): Location
    {
        $this->region = $region;
        return $this;
    }


    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): Location
    {
        $this->country = $country;
        return $this;
    }


    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): Location
    {
        $this->latitude = $latitude;
        return $this;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): Location
    {
        $this->longitude = $longitude;
        return $this;
    }


    public function getTimezone(): string
    {
        return $this->timezone;
    }

    public function setTimezone(string $timezone): Location
    {
        $this->timezone = $timezone;
        return $this;
    }


    public function getLocaltimeEpoch(): int
    {
        return $this->localtimeEpoch;
    }

    public function setLocaltimeEpoch(int $localtimeEpoch): Location
    {
        $this->localtimeEpoch = $localtimeEpoch;
        return $this;
    }


    public function getLocaltime(): string
    {
        return $this->localtime;
    }

    public function setLocaltime(string $localtime): Location
    {
        $this->localtime = $localtime;
        return $this;
    }
}
