<?php

namespace App;

use App\Lektrico\Power;
use App\Lektrico\ChargerInfo;
use App\Lektrico\ChargerState;
use Illuminate\Support\Facades\Http;

class Lektrico {
    public function __construct(public string $host) {}

    public function get(string $uri)
    {
        return Http::get("http://{$this->host}/rpc/{$uri}")->json();
    }

    public function post(array $data) 
    {
        return Http::post("http://{$this->host}/rpc", $data)->json();

    }

    public function info()
    {
        $info = $this->get("charger_info.get");
        $config = $this->get("app_config.get");

        dump($info, $config);

        return new ChargerInfo(
            state: ChargerState::fromString($info["extended_charger_state"]),
            instantPower: new Power($info["instant_power"]),
            chargingTimeInSeconds: $info["charging_time"],
            sessionEnergyInKWh: $info["session_energy"],
            requestedCurrent: $config["user_current"],
        );
    }

    public function start()
    {
        return $this->post([
            "src" => "HASS",
            "id" => random_int(10_000_000, 99_999_999),
            "method" => "charge.start",
            "params" => ["tag" => "HASS"],
        ]);
    }

    public function stop()
    {
        return $this->post([
            "src" => "HASS",
            "id" => random_int(10_000_000, 99_999_999),
            "method" => "charge.stop",
        ]);
    }

    public function setUserCurrent(int $currentInA)
    {
        return $this->post([
            "src" => "HASS",
            "id" => random_int(10_000_000, 99_999_999),
            "method" => "app_config.set",
            "params" => ["config_key" => "user_current", "config_value" => $currentInA],
        ]);
    }
}