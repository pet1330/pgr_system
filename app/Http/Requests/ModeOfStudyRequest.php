<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\ModeOfStudy;

class ModeOfStudyRequest extends FormRequest
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
                $mod = ModeOfStudy::where('name', $this->name)->first();
                return [
                    'name' => [
                        'required',
                        'min:3',
                        'unique:modes_of_study,name' . (is_null($mod)? "" : ",".$mod->id),
                    ],
                    'timing_factor' => [
                        'required',
                        'numeric',
                        'min:0.01',
                        'max:20',
                    ],
                ];
            case 'POST':
                return [
                    'name' => [
                    'required',
                    'min:3',
                    Rule::unique('modes_of_study')
                    ],
                    'timing_factor' => [
                        'required',
                        'numeric',
                        'min:0.01',
                        'max:20',
                    ],
                ];
        }
    }
}
