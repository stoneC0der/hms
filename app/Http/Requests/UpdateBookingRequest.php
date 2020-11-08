<?php

namespace App\Http\Requests;

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
            'tenant_id' => 'required|exists:tenants,id',
            'from'      => 'required|date',
            'to'        => 'required|date',
            'currency'  => 'required',
            'amount'    => 'required|numeric',
            'balance'   => 'nullable|numeric',
        ];
    }

    public function processData($booking)
    {
        // TODO:  Remove duration from form fields and generate it base on date range from-to and save to database.
        $from = Carbon::create($this->from);
        $to = Carbon::create($this->to);
        $booking->room_id   = $this->room_id;
        $booking->duration  = $from->diffInMonths($to);
        $booking->from      = $this->from;
        $booking->to        = $this->to;
        $booking->currency  = $this->currency;
        $booking->amount    = $this->amount;
        $booking->balance   = $this->balance;

        return $booking;
    }
}
