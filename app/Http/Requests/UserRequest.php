<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            "id"=>"required",
            "email" => "sometimes|email",
            'first_name' => 'sometimes|string|alpha|max:255',
            'last_name' => 'sometimes|string|alpha|max:255',
            'city' => 'sometimes|string|alpha|max:255',
            'address' => 'sometimes|string|max:255',
            'zip_code' => 'sometimes|string|regex:/^\d{5}(-\d{4})?$/',
            'phone' => 'sometimes|string|regex:/^[0-9]+$/|min:10|max:15'
        ];
    }
}
