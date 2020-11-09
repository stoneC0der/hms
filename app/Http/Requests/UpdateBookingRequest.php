<?php

namespace App\Http\Requests;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class UpdateBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'room_id'   => 'required|exists:rooms,id',
            'room_type' => 'required|exists:room_types,price',
            'tenant_id' => 'required|exists:tenants,id',
            'from'      => 'required|date',
            'to'        => 'required|date',
            'amount'    => 'required|string',
            'balance'   => 'nullable|string',
        ];
    }

    public function processData($booking): object
    {
        // TODO:  Remove duration from form fields and generate it base on date range from-to and save to database.

        // Handle room availability
        $new_room = Room::find($this->room_id);
        $old_room = $booking->room;
        if ($new_room != $old_room) {
            $this->setRoomAvailability($new_room, $old_room);
        }
        
        // TODO:  add image upload.
        $booking->room_id   = $this->room_id;
        // $booking->tenant_id = $booking->tenant->id; // This might not be necessary
        $booking->room_type_id  = $new_room->type->id;
        $booking->from      = $this->from;
        $booking->to    = $this->to;
        $booking->amount    = $this->amount;
        // Set duration
        $from = Carbon::create($this->from);
        $to = Carbon::create($this->to);
        $booking->duration  = $from->diffInMonths($to);
        // $booking->balance   = $this->balance;

        return $booking;
    }

    /**
     * Set room availability based on type
     *
     * @param Model|Collection|Builder[]|Builder|null $new_room the incoming room
     * @param Model|Collection|Builder[]|Builder|null $old_room the current room
     */
    public function setRoomAvailability($new_room, $old_room):void
    {
        if ($new_room->type->type == 'single') {
            $new_room->is_available = boolVal(false);
            $old_room->is_available = boolVal(true);
        } else {
            $old_room->is_available = boolVal(true);
            $new_room_exists = Booking::where('room_id', $new_room->id)->count();
            if ($new_room_exists >= 1) {
                $new_room->is_available = boolVal(false);
            }
        }
        $old_room->save();
        $new_room->save();
    }
}
