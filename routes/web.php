<?php

use App\Lektrico;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $lektrico = new Lektrico('192.168.68.101');

    return view('welcome', [
        'info' => $lektrico->info(),
    ]);
});

Route::post('/lektrico/start', function () {
    $lektrico = new Lektrico('192.168.68.101');

    $lektrico->start();
    return back();
});

Route::post('/lektrico/stop', function () {
    $lektrico = new Lektrico('192.168.68.101');

    $lektrico->stop();
    return back();
});

Route::post('/lektrico/set_current', function () {
    $lektrico = new Lektrico('192.168.68.101');

    $lektrico->setUserCurrent(request('current'));
    return back();
});