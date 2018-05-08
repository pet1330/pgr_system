<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRecordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'funding_type_id' => [
                'required',
                'exists:funding_types,id',
            ],
            'school_id' => [
                'required',
                'exists:schools,id',
            ],
            'enrolment_status_id' => [
                'required',
                'exists:enrolment_statuses,id',
            ],
            'student_status_id' => [
                'required',
                'exists:student_statuses,id',
            ],
            'programme_id' => [
                'required',
                'exists:programmes,id',
            ],
            'enrolment_date' => [
                'required',
                'date',
            ],
            'tierFour' => [
                'required',
                'boolean',
            ],
        ];
    }
}
