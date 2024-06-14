<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RateProductRequest extends FormRequest
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
            "value" => 'required|integer|min:1|max:5',
            "product_id" => 'required|integer|exists:products,id',
            "description" => 'string|nullable'
        ];
    }
    public function messages(): array
    {
        return [
            'value.required' => 'Field is required',
            'product_id.required' => 'Field is required'

        ];
    }
}
