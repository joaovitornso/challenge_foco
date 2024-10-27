<?php

use App\Http\Controllers\HotelController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

Route::get('/status',[HotelController::class, 'status']);
Route::get('/hotels',[HotelController::class, 'hotels']);
Route::get('/hotel-by-id/{id}',[HotelController::class, 'hotelById']);
Route::post('/hotel',[HotelController::class, 'hotel']);
Route::post('/create-hotel',[HotelController::class, 'createHotel']);
Route::put('/update-hotel',[HotelController::class, 'updateHotel']);
Route::delete('/delete-hotel/{id}',[HotelController::class, 'deleteHotel']);


Route::get('/status-room',[RoomController::class, 'status']);
Route::get('/rooms',[RoomController::class, 'rooms']);
Route::get('/room-by-id/{id}',[RoomController::class, 'RoomById']);
Route::post('/room',[RoomController::class, 'room']);
Route::post('/create-room',[RoomController::class, 'createRoom']);

