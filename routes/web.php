<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProximityAlertController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/check-proximity', [ProximityAlertController::class, 'checkProximity'])->name('check.proximity');

Route::get('/proximity-form', [ProximityAlertController::class, 'showForm'])->name('proximity.form');
