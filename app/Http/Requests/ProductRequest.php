<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            "id" => 'nullable|integer',
            "name" => "required|string|unique:products,name",
            'price' => 'required|numeric|min:1.0',
            'description' => 'string|nullable',
            'gender' => 'required|integer|in:1,2,3',
            'brand_id' => 'required|integer|exists:brands,id',
            'color_id' => 'required|integer|exists:colors,id',
            'categories' => 'required|array',
            'categories.*' => 'required|integer|exists:category,id',
            'sizes' => 'required|array',
            'sizes.*.size_id' => 'required|integer|exists:size,id',
            'sizes.*.amount' => 'required|integer|min:1',
            'images' => 'required|array|min:1|max:6',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,webp'
        ];
    }
}
