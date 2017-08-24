<?php

namespace App\Http\Requests;

use App\Models\MilestoneType;
use Illuminate\Foundation\Http\FormRequest;

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
                $mt = MilestoneType::where('name', '=' ,$this->name)->first();
                return [
                    'name' => [
                        'required',
                        'min:3',
                        'unique:milestone_types,name' . (is_null($mt)? "" : ",".$mt->id)
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
                    'unique:milestone_types,name'
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
