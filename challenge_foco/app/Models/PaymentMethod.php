<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'method_name',
    ];


    protected function methodId(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->attributes['method_name'],
            set: fn ($value) => $this->attributes['method_name'] = $value
        );
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
