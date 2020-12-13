<?php

namespace App\Service\Api\Weather\Entities;

class ForecastDay
{

    private ?string $date = null;
    private ?string $dateEpoch = null;
    private ?Day $day = null;


    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): ForecastDay
    {
        $this->date = $date;
        return $this;
    }

    public function getDateEpoch(): ?string
    {
        return $this->dateEpoch;
    }

    public function setDateEpoch(string $dateEpoch): ForecastDay
    {
        $this->dateEpoch = $dateEpoch;
        return $this;
    }

    public function getDay(): ?Day
    {
        return $this->day;
    }

    public function setDay(Day $day): ForecastDay
    {
        $this->day = $day;
        return $this;
    }
}
