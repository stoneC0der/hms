<?php

namespace App\Http\Requests;

use App\Models\Room;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->auth();
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
            'room_number'   => [
                'required',
                'alpha_num',
                Rule::unique('room')->ignore(Room::where('room_number', $this->room_number)->orWhere('room_type_id', $this->room_type_id)->first()),
            ],
        ];
    }

    public function processData($room)
    {
        $room->room_type_id = $this->room_type_id;
        $room->room_number  = $this->room_number;

        return $room;
    }
}
