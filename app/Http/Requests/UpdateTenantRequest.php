<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTenantRequest extends FormRequest
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
            'phone'         => [
                'required',
                'regex:/^\(?(\+233)?\)?(0[235][7463]\d{7,})$/',
                Rule::unique('tenants')->ignore($this->tenant)
            ], // TODO add the ability to add any valid number.
            'email'         => [
                'nullable',
                'email',
                Rule::unique('tenants')->ignore($this->tenant),
            ],
            'picture'       => 'nullable|image|mimes:png,jpeg,jpg,webp',
            'occupation'    => 'required|string|in:worker,student',
            'where'         => 'required|string',
        ];
    }

    public function processData($tenant)
    {
        $tenant->first_name = $this->first_name;
        $tenant->last_name = $this->last_name;
        $tenant->phone = $this->phone;
        $tenant->email = $this->email;
        $tenant->picture = $this->picture;
        $tenant->occupation = $this->occupation;
        $tenant->where = $this->where;

        return $tenant;
    }
}
