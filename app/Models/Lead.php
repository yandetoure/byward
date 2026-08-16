<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'type', 'locale', 'name', 'email', 'phone', 'company', 'message',
        'origin', 'destination', 'shipment_type', 'weight',
        'length', 'width', 'height', 'pickup_date', 'photo_paths',
        'origin_street', 'origin_province', 'origin_postal_code',
        'destination_street', 'destination_province', 'destination_postal_code',
    ];

    protected function casts(): array
    {
        return [
            'pickup_date' => 'date',
            'handled' => 'boolean',
            'weight' => 'decimal:2',
            'photo_paths' => 'array',
        ];
    }
}
