<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SizeRequest extends FormRequest
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
        $rules = [];

        if ($this->has('name')) {
            $rules['name'] = 'required|string|unique:size,name|regex:/^[A-Z]*$/';
        }
        if ($this->has('id')) {
            $rules['id'] = 'integer|required|exists:size,id';
        }

        return $rules;
    }
}
