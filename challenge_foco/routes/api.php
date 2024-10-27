<?php

use App\Http\Controllers\HotelController;
use Illuminate\Support\Facades\Route;

Route::get('/status',[HotelController::class, 'status']);
Route::get('/hotels',[HotelController::class, 'hotels']);

