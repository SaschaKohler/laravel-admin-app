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
            'first' => 'required|min:3|max:20',
            'last' => 'required|min:3|max:20',
            'email' => 'required|email',
            'phone' => 'required|numeric'
        ];
    }
}
