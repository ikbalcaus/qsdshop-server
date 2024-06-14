<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            "id" => "required|exists:orders,id",
            "status"=>"required",
            "comment"=>"nullable|string|max:255",
        ];
    }
    public function messages()
    {
        return [
            'id.required' => 'The ID is required.',
            'id.exists' => 'The selected ID does not exist in the brands table.',
            'status.required' => 'Status is required to be set.'
        ];
    }

}
