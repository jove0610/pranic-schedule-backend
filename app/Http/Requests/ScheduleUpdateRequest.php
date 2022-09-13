<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'course_id' => ['exists:courses,id', 'numeric'],
            'office_id' => ['exists:offices,id', 'numeric'],
            'img_ref' => ['active_url'],
            'date_start' => ['date_format:Y-m-d'],
            'date_end' => ['date_format:Y-m-d'],
        ];
    }
}
