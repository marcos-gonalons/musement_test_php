<?php

namespace Src\Service\Api\Weather\Entities;

class Day
{

    private Condition $condition;
    private float $maxTempC;
    private float $maxTempF;
    private float $minTempC;
    private float $minTempF;
    private float $avgTempC;
    private float $avgTempF;
    private float $maxWindMph;
    private float $maxWindKph;
    private float $totalPrecipMm;
    private float $totalPrecipIn;
    private float $avgVisKm;
    private float $avgVisMiles;
    private float $avgHumidity;
    private float $dailyWillItRain;
    private float $dailyChanceOfRain;
    private float $dailyWillItSnow;
    private float $dailyChanceOfSnow;
    private float $uv;


    public function getCondition(): Condition
    {
        return $this->condition;
    }

    public function setCondition(Condition $condition): Day
    {
        $this->condition = $condition;
        return $this;
    }

    public function getMaxTempC(): float
    {
        return $this->maxTempC;
    }

    public function setMaxTempC(float $maxTempC): Day
    {
        $this->maxTempC = $maxTempC;
        return $this;
    }

    public function getMaxTempF(): float
    {
        return $this->maxTempF;
    }

    public function setMaxTempF(float $maxTempF): Day
    {
        $this->maxTempF = $maxTempF;
        return $this;
    }

    public function getMinTempC(): float
    {
        return $this->minTempC;
    }

    public function setMinTempC(float $minTempC): Day
    {
        $this->minTempC = $minTempC;
        return $this;
    }

    public function getMinTempF(): float
    {
        return $this->minTempF;
    }

    public function setMinTempF(float $minTempF): Day
    {
        $this->minTempF = $minTempF;
        return $this;
    }

    public function getAvgTempC(): float
    {
        return $this->avgTempC;
    }

    public function setAvgTempC(float $avgTempC): Day
    {
        $this->avgTempC = $avgTempC;
        return $this;
    }

    public function getAvgTempF(): float
    {
        return $this->avgTempF;
    }

    public function setAvgTempF(float $avgTempF): Day
    {
        $this->avgTempF = $avgTempF;
        return $this;
    }


    public function getMaxWindMph(): float
    {
        return $this->maxWindMph;
    }

    public function setMaxWindMph(float $maxWindMph): Day
    {
        $this->maxWindMph = $maxWindMph;
        return $this;
    }


    public function getMaxWindKph(): float
    {
        return $this->maxWindKph;
    }

    public function setMaxWindKph(float $maxWindKph): Day
    {
        $this->maxWindKph = $maxWindKph;
        return $this;
    }


    public function getTotalPrecipMm(): float
    {
        return $this->totalPrecipMm;
    }

    public function setTotalPrecipMm(float $totalPrecipMm): Day
    {
        $this->totalPrecipMm = $totalPrecipMm;
        return $this;
    }


    public function getTotalPrecipIn(): float
    {
        return $this->totalPrecipIn;
    }

    public function setTotalPrecipIn(float $totalPrecipIn): Day
    {
        $this->totalPrecipIn = $totalPrecipIn;
        return $this;
    }


    public function getAvgVisKm(): float
    {
        return $this->avgVisKm;
    }

    public function setAvgVisKm(float $avgVisKm): Day
    {
        $this->avgVisKm = $avgVisKm;
        return $this;
    }


    public function getAvgVisMiles(): float
    {
        return $this->avgVisMiles;
    }

    public function setAvgVisMiles(float $avgVisMiles): Day
    {
        $this->avgVisMiles = $avgVisMiles;
        return $this;
    }


    public function getAvgHumidity(): float
    {
        return $this->avgHumidity;
    }

    public function setAvgHumidity(float $avgHumidity): Day
    {
        $this->avgHumidity = $avgHumidity;
        return $this;
    }


    public function getDailyWillItRain(): float
    {
        return $this->dailyWillItRain;
    }

    public function setDailyWillItRain(float $dailyWillItRain): Day
    {
        $this->dailyWillItRain = $dailyWillItRain;
        return $this;
    }


    public function getDailyChanceOfRain(): float
    {
        return $this->dailyChanceOfRain;
    }

    public function setDailyChanceOfRain(float $dailyChanceOfRain): Day
    {
        $this->dailyChanceOfRain = $dailyChanceOfRain;
        return $this;
    }


    public function getDailyWillItSnow(): float
    {
        return $this->dailyWillItSnow;
    }

    public function setDailyWillItSnow(float $dailyWillItSnow): Day
    {
        $this->dailyWillItSnow = $dailyWillItSnow;
        return $this;
    }


    public function getDailyChanceOfSnow(): float
    {
        return $this->dailyChanceOfSnow;
    }

    public function setDailyChanceOfSnow(float $dailyChanceOfSnow): Day
    {
        $this->dailyChanceOfSnow = $dailyChanceOfSnow;
        return $this;
    }


    public function getUv(): float
    {
        return $this->uv;
    }

    public function setUv(float $uv): Day
    {
        $this->uv = $uv;
        return $this;
    }
}
