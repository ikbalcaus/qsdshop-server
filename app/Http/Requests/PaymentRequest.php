<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'full_name' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'zip' => 'required|string',
            'phone' => 'required|string',
            'total_price' => 'required|integer|min:1',
            'card_number'=>'required|string',
            'expiration_month'=>'required|integer|between:1,12',
            'expiration_year'=>'required|integer',
            'cvc'=>'required|string'
        ];
    }
}
