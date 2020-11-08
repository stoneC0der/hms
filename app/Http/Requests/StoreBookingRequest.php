<?php

namespace App\Http\Requests;

use App\Models\RoomType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class StoreBookingRequest extends FormRequest
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
            'first_name'    => 'required|string|max:250',
            'last_name'     => 'required|string|max:250',
            // TODO:   add the ability to add any valid number.
            'phone'         => 'required|regex:/^\(?(\+233)?\)?(0[235][7463]\d{7,})$/|unique:tenants,phone', 
            'email'         => 'nullable|email|unique:tenants,email',
            'picture'       => 'nullable|file|image|mimes:png,jpeg,jpg,webp',
            'occupation'    => 'required|string|in:worker,student',
            'where'         => 'required|string',
            'room_id'       => 'required|exists:rooms,id',
            'room_type'     => 'required|exists:room_types,price',
            'from'          => 'required|date',
            'to'            => 'required|date',
            'amount'        => 'required|numeric',
            // 'balance'       => 'nullable|numeric',
        ];
    }

    public function processData()
    {
        $roomType = RoomType::where('price', $this->room_type)->first();
        $from = Carbon::create($this->from);
        $to = Carbon::create($this->to);
        $booking = [
            'room_id'   => $this->room_id,
            'tenant_id' => $this->tenant_id,
            'duration'  => $from->diffInMonths($to),
            'from'      => $this->from,
            'to'        => $this->to,
            'room_type_id'  => $roomType->id,
            'amount'    => $this->amount,
            // 'balance'   => $this->balance,
        ];
        $tenant = [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'email' => $this->email,
            'picture' => $this->picture,
            'occupation' => $this->occupation,
            'where' => $this->where,
        ];
        return ['tenant' => $tenant, 'booking' => $booking, 'room_type' => $roomType->type];
    }
    
}
