<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'tracking_number',
        'status',
        'origin',
        'destination',
        'current_location',
        'expected_delivery_date',
        'notes',
    ];
}
