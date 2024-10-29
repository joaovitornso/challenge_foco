<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'reserve_id',
        'method_id',
        'value',
    ];

    protected function reserveId(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->attributes['reserve_id'],
            set: fn ($value) => $this->attributes['reserve_id'] = $value
        );
    }

    protected function methodId(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->attributes['method_id'],
            set: fn ($value) => $this->attributes['method_id'] = $value
        );
    }

    protected function value(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->attributes['value'],
            set: fn ($value) => $this->attributes['value'] = $value
        );
    }

    public function reserve()
    {
        return $this->belongsTo(Reserve::class);
    }

    public function method()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
