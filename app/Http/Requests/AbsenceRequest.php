<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AbsenceRequest extends FormRequest
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
            'absence_type_id' => [
                'required',
                'exists:absence_types,id',
            ],
            'from' => [
                'date',
            ],
            'to' => [
                'date',
                'after_or_equal:from',
            ],
            'duration' => [
                'required',
                'integer',
                'min:0',
            ],
        ];
    }
}
