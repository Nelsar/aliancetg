<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
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
            'phone_invite' => 'required|string',
            'phone' => 'required|string|unique:users',
            'birthday' => 'required|date',
            'name' => 'required|string',
            'gender' => 'required|integer',
            'iin' => 'required|string|min:12|max:12',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed|min:6|max:30',
        ];
    }
}