<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    protected $fillable = ['service_name', 'duration', 'price', 'description', 'icon', 'order'];

    public $timestamps = false;

    protected $casts = [
        'price' => 'decimal:2',
        'order' => 'integer',
    ];
}

