<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Daily extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'reserve_id',
        'date',
        'value',
    ];

    public function reserve()
    {
        return $this->belongsTo(Reserve::class);
    }

    protected function date(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->attributes['date'],
            set: fn ($value) => $this->attributes['date'] = $value
        );
    }

    protected function value(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->attributes['value'],
            set: fn ($value) => $this->attributes['value'] = $value
        );
    }

    protected function reserveId(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->attributes['reserve_id'],
            set: fn ($value) => $this->attributes['reserve_id'] = $value
        );
    }
}
