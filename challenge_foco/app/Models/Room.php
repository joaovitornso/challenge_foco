<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    protected $fillable = [
        'id',
        'hotelCode',
        'name',
    ];


    public function getHotelCodeAttribute()// Acessor
    {
        return $this->attributes['hotel_id'];
    }

    public function setHotelCodeAttribute($value) // Mutador
    {
        $this->attributes['hotel_id'] = $value;
    }
}
