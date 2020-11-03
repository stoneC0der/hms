<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookingRequest extends FormRequest
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
            'room_id'   => 'required|exists:rooms,id',
            'tenant_id' => 'required|exists:tenants,id',
            'duration'  => 'required|numeric',
            'from'      => 'required|date',
            'to'        => 'required|date',
            'currency'  => 'required',
            'amount'    => 'required|numeric',
            'balance'   => 'nullable|numeric',
        ];
    }

    public function processData($booking)
    {
        $booking->room_id   = $this->room_id;
        $booking->tenant_id = $this->tenant_id;
        $booking->duration  = $this->duration;
        $booking->from      = $this->from;
        $booking->to        = $this->to;
        $booking->currency  = $this->currency;
        $booking->amount    = $this->amount;
        $booking->balance   = $this->balance;

        return $booking;
    }
}
