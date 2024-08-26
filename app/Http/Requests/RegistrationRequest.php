<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
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
            'name' => 'required|string|min:2|max:60',
            'email' => 'required|string|min:6|max:100',
            'phone' => 'required|string|regex:/^\+380\d{9}$/',
            'position_id' => 'required|integer|min:1',
            'photo' => 'required|image|mimes:jpeg,jpg,png|dimensions:min_width=70,min_height=70',
        ];
    }
}