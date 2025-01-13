<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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
            'total_number' => 'nullable|integer|min:0',
            'total_price' => 'nullable|integer|min:0',
            'status' => 'nullable|integer|in:0,1,2,3',
            'duration' => 'nullable|integer|min:0',
            'customer_id' => 'nullable|exists:users,id',
            'food_id' => 'nullable|exists:foods,id',
        ];
    }
}
