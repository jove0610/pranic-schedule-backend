<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleIndexRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'date_start' => ['required', 'date_format:Y-m-d'],
            'date_end' => ['required', 'date_format:Y-m-d'],
            'course_id' => ['exists:courses,id', 'numeric'],
            'office_id' => ['exists:offices,id', 'numeric'],
            'state_id' => ['exists:states,id', 'numeric'],
            'country_id' => ['exists:countries,id', 'numeric'],
        ];
    }
}
