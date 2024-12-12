<?php

use Illuminate\Support\Facades\Route;

Route::get('/{any}', function () {
    return view('app'); // The Blade template where Vue is mounted
})->where('any', '.*');
