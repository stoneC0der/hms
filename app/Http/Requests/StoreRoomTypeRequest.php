<?php

namespace App\Http\Requests;

use App\Models\RoomType;
use Illuminate\Foundation\Http\FormRequest;

class StoreRoomTypeRequest extends FormRequest
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
            'type'                  => 'required|string',
            'has_internal_bathroom' => 'nullable|boolean',
        ];
    }

    public function processData()
    {
        $room_type = new RoomType();

        $room_type->type = $this->type;
        $room_type->has_internal_bathroom = boolval($this->has_internal_bathroom);

        return $room_type;
    }
}
