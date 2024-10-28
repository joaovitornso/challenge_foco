<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reserve extends Model
{
    protected $fillable = [
        'id',
        'hotelCode',
        'roomCode',
        'checkIn',
        'checkOut',
        'total',
    ];

    public function getHotelCodeAttribute()// Acessor
    {
        return $this->attributes['hotel_id'];
    }

    public function setHotelCodeAttribute($value) // Mutador
    {
        $this->attributes['hotel_id'] = $value;
    }

    public function getRoomCodeAttribute()// Acessor
    {
        return $this->attributes['room_id'];
    }

    public function setRoomCodeAttribute($value) // Mutador
    {
        $this->attributes['room_id'] = $value;
    }

}
