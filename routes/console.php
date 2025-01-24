<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Schedule::call(function () {
    (new Lektrico('192.168.68.101'))->start();
})->dailyAt('22:15');
Schedule::call(function () {
    (new Lektrico('192.168.68.101'))->stop();
})->dailyAt('05:55');
