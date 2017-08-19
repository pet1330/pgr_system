<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MilestoneTypeRequest extends FormRequest
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
                $abst = Programme::where('name', $this->name)->first();
                return [
                    'name' => [
                        'required',
                        'min:3',
                        Rule::unique('milestone_types')->ignore($id),
                    ],
                    'duration' => [
                        'nullable',
                        'integer',
                        'min:1',
                        'max:600',
                    ],
                ];
            case 'POST':
                return [
                    'name' => [
                    'required',
                    'min:3',
                    Rule::unique('milestone_types')
                    ],
                    'duration' => [
                        'nullable',
                        'integer',
                        'min:1',
                        'max:600',
                    ],
                ];
        }
    }
}
