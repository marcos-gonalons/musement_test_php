<?php

namespace App\Service\Api\Weather\Entities;

class Condition
{

    private string $text;
    private string $icon;
    private int $code;


    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): Condition
    {
        $this->text = $text;
        return $this;
    }

    public function getIcon(): string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): Condition
    {
        $this->icon = $icon;
        return $this;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function setCode(int $code): Condition
    {
        $this->code = $code;
        return $this;
    }
}
