<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoomTypeRequest extends FormRequest
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
            'type'                  => 'required|string',
            'has_internal_bathroom' => 'nullable|boolean',
        ];
    }

    public function processData($room_type)
    {
        $room_type->type = $this->type;
        $room_type->has_internal_bathroom = boolval($this->has_internal_bathroom);

        return $room_type;
    }
}
