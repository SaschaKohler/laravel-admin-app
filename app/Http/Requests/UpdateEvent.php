<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEvent extends FormRequest
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
            'finished' => 'nullable|boolean',
            'type' => 'required',
            'start' => 'required',
            'customer_id' => 'required',
            'recurrence' => 'required|min:0',
        ];
    }
}
