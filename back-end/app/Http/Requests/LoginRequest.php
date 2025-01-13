<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Set to false if you have additional authorization logic
    }

    public function rules()
    {
        return [
            'email' => 'required_without:username|string|email|max:255|exists:users,email',
            'username' => 'required_without:email|string|max:255|exists:users,username',
            'password' => 'required|string|min:8',
        ];
    }
}
