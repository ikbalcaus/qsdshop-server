<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
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
            'id'=>'required|exists:brands,id',
            'name'=>'required|string|not_regex:/^\s*$/|unique:brands,name,'
        ];
    }
    public function messages()
    {
        return [
            'id.required' => 'The ID is required.',
            'id.exists' => 'The selected ID does not exist in the brands table.',
            'name.required' => 'The brand name is required.',
            'name.string' => 'The brand name must be a string.',
            'name.not_regex' => 'The brand name must not be empty.',
            'name.unique' => 'The brand name has already been taken.',
        ];
    }
}
