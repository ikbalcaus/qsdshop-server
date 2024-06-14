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
            'phone' => 'sometimes|string|regex:/^[0-9]+$/|min:10|max:15',
            'role'=>'sometimes|in:1,2,3,4'
        ];
    }
    public function messages(): array
    {
        return [
            'id.required' => 'The user ID is required.',
            'email.email' => 'The email must be a valid email address.',
            'first_name.alpha' => 'The first name may only contain letters.',
            'first_name.max' => 'The first name may not be greater than 255 characters.',
            'last_name.alpha' => 'The last name may only contain letters.',
            'last_name.max' => 'The last name may not be greater than 255 characters.',
            'city.alpha' => 'The city name may only contain letters.',
            'city.max' => 'The city name may not be greater than 255 characters.',
            'address.max' => 'The address may not be greater than 255 characters.',
            'zip_code.regex' => 'The zip code format is invalid. It should be 5 digits or 5 digits followed by a hyphen and 4 digits.',
            'phone.regex' => 'The phone number format is invalid. It should contain only numbers.',
            'phone.min' => 'The phone number must be at least 10 digits.',
            'phone.max' => 'The phone number may not be greater than 15 digits.',
            'role.in' => 'The selected role is invalid. It must be one of the following values: 1, 2, 3, or 4.'
        ];
    }
}
