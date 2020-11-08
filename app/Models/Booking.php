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
        'room_type_id',
        'duration',
        'from',
        'to',
        'currency',
        'amount',
        'balance',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function tenants()
    {
        return $this->hasMany(Tenant::class, 'id', 'tenant_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function room_type()
    {
        return $this->belongsTo(RoomType::class, 'room_type_id');
    }
}