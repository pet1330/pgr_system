<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\AbsenceType;

class AbsenceTypeRequest extends FormRequest
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
                $abst = AbsenceType::where('name', '=' ,$this->name)->first();
                return [
                        'name' => [
                            'required',
                            'min:3',
                            'unique:absence_types,name' . (is_null($abst)? "" : ",".$abst->id)
                        ],
                        'interuption'=> [
                            'required',
                            'boolean'
                        ]
                ];
            case 'POST':
                return 
                [
                    'name' => [
                        'required',
                        'min:3',
                        'unique:absence_types,name'
                    ],
                    'interuption'=> [
                        'required',
                        'boolean'
                    ]
                ];
        }
    }
}
