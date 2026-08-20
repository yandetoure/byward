<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobOffer extends Model
{
    use HasFactory;

    protected $table = 'job_offers';

    protected $fillable = [
        'title_en',
        'title_fr',
        'description_en',
        'description_fr',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
