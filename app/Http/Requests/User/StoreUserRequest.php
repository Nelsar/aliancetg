<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Auth;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        //return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

     public function rules()
     {
        return[
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:5|max:30',
            'parent_id' => ['nullable', 'integer'],
            'admin_id' => ['nullable', 'integer'],
            'phone' => 'required|string',
            'iin' => 'nullable|string|min:12|max:12',
            'birthday' => 'nullable|date',
            'status' => 'boolean',
            'gender' => 'required|integer',
        ];
     }
}