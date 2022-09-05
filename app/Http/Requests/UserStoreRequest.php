<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'avatar_url' => ['string'],
            'is_admin' => ['required', 'boolean'],
            'email' => ['required', 'unique:users', 'string'],
            'password' => ['required', 'confirmed', Password::min(8), 'string'],
        ];
    }
}
