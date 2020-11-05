<?php

namespace App\Http\Requests;

use App\Models\Room;
use Illuminate\Foundation\Http\FormRequest;

class StoreRoomRequest extends FormRequest
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
            'room_type_id'     => 'required|exists:room_types,id',
            'room_number'   => 'required|alpha_num|unique:rooms,room_number',
        ];
    }

    public function processData()
    {
        $room = new Room();

        $room->room_type_id = $this->room_type_id;
        $room->room_number  = $this->room_number;

        return $room;
    }
}
