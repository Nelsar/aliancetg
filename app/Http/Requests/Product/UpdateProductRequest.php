<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
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
            'sku' => 'nullable|string',
            'fullName' => 'nullable|string',
            'article' => 'nullable|string',
            'quantity' => 'nullable|integer',
            'price' => 'required|decimal',
            'description' => 'nullable|nullable',
            'images' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:32768',
            'category' => 'nullable|integer'
        ];
    }
}
