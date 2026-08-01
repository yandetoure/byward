<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'type', 'locale', 'name', 'email', 'phone', 'company', 'message',
        'origin', 'destination', 'shipment_type', 'weight',
        'length', 'width', 'height', 'pickup_date',
    ];

    protected function casts(): array
    {
        return [
            'pickup_date' => 'date',
            'handled' => 'boolean',
            'weight' => 'decimal:2',
        ];
    }
}
