<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiscountRequest extends FormRequest
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
            'name' => 'required|string',
            'discount' => 'required|integer',
            'valid_from' => 'required|date',
            'valid_to' => 'required|date',
            'discount_id' => 'nullable|numeric',
            'products.*' => 'nullable|exists:products,id',
            'brands.*' => 'nullable|exists:brands,id',
            'colors.*' => 'nullable|string',
            'sizes.*' => 'nullable|string',
            'categories.*' => 'nullable|string',
            'genders.*' => 'nullable|string',
        ];
    }
}
