<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfficeIndexRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'per_page' => ['numeric', 'max:50'],
            'state_id' => ['numeric', 'exists:states,id'],
            'country_id' => ['numeric', 'exists:countries,id'],
        ];
    }
}
