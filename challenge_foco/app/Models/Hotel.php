<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Hotel extends Model
{
    protected $fillable = [
        'id',
        'name',
    ];


    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->attributes['name'],
            set: fn ($value) => $this->attributes['name'] = $value
        );
    }

}
