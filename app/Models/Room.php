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
    
    /**
     * Get All available room base on room type (used by ajax call mostly)
     * 
     * @param string|int|null $room_type_id The type of room, default null.
     * 
     * @return mixed 
     */
    public function scopeAllAvailable($query, $room_type_id = null)
    {
        if (is_null($room_type_id)) {
            return $query->where('is_available', true);
        }
        return $query->where('is_available', true)->where('room_type_id', $room_type_id);
    }

    /**
     * Get All available rooms including current booked room
     * Use for editing booked the first method don't include tenant room when retrieving rooms.
     * This might call for a refactoring to have as single method to perform that task or not.
     * 
     * @param mixed $query The query builder
     * @param string|int $room_type_id The room type.
     * @param string|int|null $id The current tenant room id
     * 
     * @return mixed
     */
    public function scopeAvailable($query, $room_type_id, $id = null)
    {
        if (is_null($id)) {
            return $query->where('is_available', true);
        }
        return $query->where('is_available', true)->where('room_type_id', $room_type_id)->orWhere('id', $id);
    }
}