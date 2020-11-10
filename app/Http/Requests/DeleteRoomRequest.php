<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteRoomRequest extends FormRequest
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
            //
        ];
    }

    public function processData($room)
    {
        $room_is_booked = \App\Models\Rent::where('room_id', $this->room->id)->first();
        if ($room_is_booked) {
            flash("
                <i class='fas fa-exclamation-triangle mr-2'></i>The room " . $this->room->room_number . 
                " has a tenant, to delete it, first move the tenant to a new room!"
            )->warning();
            flash("
                <i class='fas fa-exclamation-circle mr-2'></i>
                This action will not delete the room from the database but simply marked it has unavailable and can be restored (FUTURE NOT YET IMPLEMENTED)."
            )->info()->important();
            return back();
        }
        dd();
        return $room->delete();
    }
}
