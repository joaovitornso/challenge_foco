<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    protected $fillable = [
        'id',
        'hotel_id',
        'name',
    ];


    protected function hotelCode(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->attributes['hotel_id'],
            set: fn ($value) => $this->attributes['hotel_id'] = $value
        );
    }
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->attributes['name'],
            set: fn ($value) => $this->attributes['name'] = $value
        );
    }

}
