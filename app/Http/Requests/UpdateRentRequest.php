<?php

namespace App\Http\Requests;

use App\Models\Rent;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class UpdateRentRequest extends FormRequest
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
            'from'      => 'required|date',
            'to'        => 'required|date',
            'amount'    => 'required|string',
            'balance'   => 'nullable|string',
        ];
    }

    public function processData($rent): object
    {
        // Make sure we have the correct room price
        $roomType = RoomType::where('price', $this->room_type)->first();
        // Handle room availability
        $new_room = Room::find($this->room_id);
        $old_room = $rent->room;
        if ($new_room != $old_room) {
            $this->setRoomAvailability($new_room, $old_room);
        }
        // Set duration
        $from = Carbon::create($this->from);
        $to = Carbon::create($this->to);
        $duration = $from->diffInMonths($to);
        // Recalculate total amount
        $total_amount = $roomType->price * $duration;
        
        // TODO:  add image upload.
        $rent->room_id   = $this->room_id;
        // $rent->tenant_id = $rent->tenant->id; // This might not be necessary
        $rent->room_type_id  = $new_room->type->id;
        $rent->from      = $this->from;
        $rent->to    = $this->to;
        $rent->amount    = $this->amount;
        $rent->duration  = ($this->amount != $total_amount) ? $total_amount : $this->amount;
        // $rent->balance   = $this->balance;

        return $rent;
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
            $new_room_exists = Rent::where('room_id', $new_room->id)->count();
            if ($new_room_exists >= 1) {
                $new_room->is_available = boolVal(false);
            }
        }
        $old_room->save();
        $new_room->save();
    }
}
