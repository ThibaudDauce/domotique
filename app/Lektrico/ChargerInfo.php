<?php

namespace App\Lektrico;

class ChargerInfo
{
    public function __construct(
        public ChargerState $state,
        public Power $instantPower,
        public int $requestedCurrent,
        public int $chargingTimeInSeconds,
        public float $sessionEnergyInKWh,
    ) {}
}