<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfficeUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'state_id' => ['exists:states,id', 'numeric'],
            'name' => ['string'],
            'contact_no' => ['string'],
            'email_address' => ['email'],
        ];
    }
}
