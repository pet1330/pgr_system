<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MilestoneRequest extends FormRequest
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
        switch($this->method())
        {
            case 'DELETE':
            return [];
            case 'PATCH':
            case 'PUT':
                return [
                    'milestone_type' => [
                    'required',
                    'exists:milestone_types,id', 
                    ],
                    'due' => [ 'date' ],
                ];
            case 'POST':
                return [
                    'milestone_type' => [
                    'required',
                    'exists:milestone_types,id',
                    ],
                    'due' => [ 'date' ],
                ];
        }
    }
}
