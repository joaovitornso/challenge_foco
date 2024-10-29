<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'reserve_id',
        'coupon_id',
        'discount_type',
        'value',
        'description',
    ];

    public function couponCode()
    {
        return $this->belongsTo(CouponCode::class);
    }

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

    protected function couponId(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->attributes['coupon_id'],
            set: fn ($value) => $this->attributes['coupon_id'] = $value
        );
    }
}
