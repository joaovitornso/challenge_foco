<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reserve extends Model
{
    protected $fillable = [
        'id',
        'hotel_id',
        'room_id',
        'check_in',
        'check_out',
        'total',
    ];

    protected function hotelCode(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->attributes['hotel_id'],
            set: fn ($value) => $this->attributes['hotel_id'] = $value
        );
    }

    protected function roomCode(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->attributes['room_id'],
            set: fn ($value) => $this->attributes['room_id'] = $value
        );
    }

    protected function checkIn(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->attributes['check_in'],
            set: fn ($value) => $this->attributes['check_in'] = $value
        );
    }

    protected function checkOut(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->attributes['check_out'],
            set: fn ($value) => $this->attributes['check_out'] = $value
        );
    }

    protected function total(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value,
            set: fn ($value) => round($value, 2)
        );
    }


}
