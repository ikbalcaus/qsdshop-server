<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequests extends FormRequest
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
            "email" => "required|email",
            'first_name' => 'required|string|alpha|max:255',
            'last_name' => 'required|string|alpha|max:255',
            'password' => 'required|string|min:8|regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
            'confirm_password' => 'required|string|same:password',
            'city' => 'string|alpha|max:255',
            'address' => 'string|max:255',
            'zip_code' => 'string|regex:/^\d{5}(-\d{4})?$/',
            'phone' => 'string|regex:/^[0-9]+$/|min:10|max:15',
            'role' => 'in:1,2,3',
            'status' => 'boolean'
        ];
    }

    public function messages()
    {
        return [
            'password.regex' => 'Password must contain at least one letter, one number, and one special character.',
            'confirm_password.regex' => 'Confirm password must be same as password.',
        ];
    }
}
