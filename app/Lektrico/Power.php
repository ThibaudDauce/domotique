<?php

namespace App\Lektrico;

class Power
{
    public function __construct(public float $kW) {}

    public function kWForHumans(): string
    {
        return number_format($this->kW, 1, ',', ' ') . ' kW';
    }
}