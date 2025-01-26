<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Set to false if you have additional authorization logic
    }

    public function rules()
    {
        return [
            'name' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'location' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'avatar' => 'required|integer|min:0|max:4',
            'role' => 'nullable|string|max:255',
        ];
    }
}
