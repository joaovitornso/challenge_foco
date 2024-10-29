<?php

use App\Http\Controllers\CouponController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\ReserveController;
use App\Http\Controllers\RoomController;
use App\Models\CouponCode;
use App\Models\Discount;
use Illuminate\Support\Facades\Route;

Route::get('/status',[HotelController::class, 'status']);
Route::get('/hotels',[HotelController::class, 'hotels']);
Route::get('/hotels-test',[HotelController::class, 'hotels1']);

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
Route::put('/update-room',[RoomController::class, 'updateRoom']);
Route::delete('/delete-room/{id}',[RoomController::class, 'deleteRoom']);

Route::get('/reserve/status',[ReserveController::class, 'status']);
Route::post('/reserve',[ReserveController::class, 'reserve']);
Route::post('/create-reserve',[ReserveController::class, 'createReserve']);

Route::get('/discounts',[DiscountController::class, 'discounts']);
Route::post('/discount',[DiscountController::class, 'discount']);
Route::post('/create-discount',[DiscountController::class, 'createDiscount']);
Route::put('/update-discount',[DiscountController::class, 'updateDiscount']);
Route::delete('/delete-discount/{id}',[DiscountController::class, 'deleteDiscount']);

Route::get('/coupons',[CouponController::class, 'coupons']);
Route::post('/coupon',[CouponController::class, 'coupon']);
Route::post('/create-coupon',[CouponController::class, 'createCoupon']);
Route::put('/update-coupon',[CouponController::class, 'updateCoupon']);
Route::delete('/delete-coupon/{id}',[CouponController::class, 'deleteCoupon']);

