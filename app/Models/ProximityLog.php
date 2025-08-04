<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProximityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'warehouse_lat',
        'warehouse_lng',
        'delivery_lat',
        'delivery_lng',
        'radius',
        'distance',
        'within_range',
    ];
}