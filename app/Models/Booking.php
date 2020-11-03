<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    /**
     * The attribute that should be cast to native type
     */
    protected $casts = [
        'from'  => 'datetime',
        'to'    => 'datetime',
    ];

    protected $fillable = [
        'room_id',
        'tenant_id',
        'duration',
        'from',
        'to',
        'currency',
        'amount',
        'balance',
    ];

}