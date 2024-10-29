<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'reserve_id',
        'name',
        'last_name',
        'phone',
    ];

    public function reserve()
    {
        return $this->belongsTo(Reserve::class);
    }

    protected function reserveId(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->attributes['reserve_id'],
            set: fn ($value) => $this->attributes['reserve_id'] = $value
        );
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->attributes['name'],
            set: fn ($value) => $this->attributes['name'] = $value
        );
    }

    protected function lastName(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->attributes['last_name'],
            set: fn ($value) => $this->attributes['last_name'] = $value
        );
    }

    protected function phone(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->attributes['phone'],
            set: fn ($value) => $this->attributes['phone'] = $value
        );
    }

}
