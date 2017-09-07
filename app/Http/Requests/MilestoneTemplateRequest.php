<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MilestoneTemplateRequest extends FormRequest
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
            'due' => [
                'required',
                'integer',
            ],
            'milestone_type' => [
                'required',
                'exists:milestone_types,id',
            ],
        ];
    }
}
