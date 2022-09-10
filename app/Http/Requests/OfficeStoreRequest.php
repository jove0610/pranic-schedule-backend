<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfficeStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'state_id' => ['required', 'exists:states,id', 'numeric'],
            'name' => ['required', 'string'],
            'contact_no' => ['string'],
            'email' => ['email'],
        ];
    }
}
