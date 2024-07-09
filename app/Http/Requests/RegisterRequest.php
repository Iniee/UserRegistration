<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            "fullname"  => ["required", "string"],
            "email"  => ["required", "email", "unique:users,email"],
            "phone"  => ["required", "string"],
            "address"  => ["required", "string"],
            "code"  => ["required", "string", "max:4", "min:4"],
        ];
    }
}