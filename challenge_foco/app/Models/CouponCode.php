<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'discount_type',
        'value',
        'description',
        'start_date',
        'end_date',
        'max_uses',
        'times_used',
    ];

    public function discounts()
    {
        return $this->hasMany(Discount::class);
    }
}
