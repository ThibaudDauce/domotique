<?php

namespace App\Lektrico;

enum ChargerState
{
    case Available;
    case Connected;
    case NeedAuth;
    case Paused;
    case Charging;
    case Error;
    case UpdatingFirmware;
    case Locked;
    case PausedByScheduler;

    public static function fromString(string $value): Self {
        return match ($value) {
            "A" => Self::Available,
            "B" => Self::Connected,
            "B_AUTH" => Self::NeedAuth,
            "B_PAUSE" => Self::Paused,
            "C" => Self::Charging,
            "E" => Self::Error,
            "OTA" => Self::UpdatingFirmware,
            "LOCKED" => Self::Locked,
            "B_SCHEDULER" => Self::PausedByScheduler,
            default => throw new Exception("Unknown charger state '{$value}'"),
        };
    }

    public function label()
    {
        return match ($this) {
            Self::Available => 'Disponible',
            Self::Connected => 'Connecté',
            Self::NeedAuth => 'En attente de lancement',
            Self::Paused => 'Pause',
            Self::Charging => 'En charge',
            Self::Error => 'Erreur',
            Self::UpdatingFirmware => 'Mise à jour en cours',
            Self::Locked => 'Verrouillée',
            Self::PausedByScheduler => 'Pause via le planning',
            default => throw new Exception("Unknown charger state '{$value}'"),
        };
    }

    public function canRun(): bool
    {
        return in_array($this, [Self::Available, Self::NeedAuth, Self::Paused, Self::PausedByScheduler]);
    }

    public function charging(): bool
    {
        return $this === Self::Charging;
    }

}