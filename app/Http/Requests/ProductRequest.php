<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'brand_id' => [
                'required',
                'integer',
                Rule::exists('brands', 'id')->whereNull('deleted_at')
            ],
            'color_id' => [
                'required',
                'integer',
                Rule::exists('colors', 'id')->whereNull('deleted_at')
            ],
            'categories' => 'required|array',
            'categories.*' => [
                'required',
                'integer',
                Rule::exists('category', 'id')->whereNull('deleted_at')
            ],
            'sizes' => 'required|array',
            'sizes.*.size_id' => [
                'required',
                'integer',
                Rule::exists('size', 'id')->whereNull('deleted_at')
            ],
            'sizes.*.amount' => 'required|integer|min:1',
            'images' => 'required|array|min:1|max:6',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,webp'
        ];
    }
}
