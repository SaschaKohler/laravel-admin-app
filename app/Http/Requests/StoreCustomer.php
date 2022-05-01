<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomer extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'sometimes|nullable|min:3|max:150',
            'last' => 'sometimes|nullable|min:3|max:150',
            'brand' => 'sometimes|nullable|min:3|max:150',
            'county' => 'sometimes|nullable|min:3|max:150',
            'email' => 'sometimes|nullable|email',
            'phone' => 'required|numeric'
        ];
    }
}
