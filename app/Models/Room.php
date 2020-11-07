<?php
    namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_number',
        'room_type_id',
    ];

    public function type()
    {
        return $this->belongsTo(RoomType::class, 'room_type_id');
    }

    public function scopeAvailable($query, $id = null)
    {
        if (is_null($id)) {
            return $query->where('is_available', true);
        }
        return $query->where('is_available', true)->orWhere('id', $id);
    }
}