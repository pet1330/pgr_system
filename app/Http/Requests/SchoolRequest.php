<?php

namespace App\Http\Requests;

use App\Models\School;
use Illuminate\Foundation\Http\FormRequest;

class SchoolRequest extends FormRequest
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
                $school = School::where('name', $this->name)->first();
                return [
                    'name' => [
                        'required',
                        'min:3',
                        'unique:schools,name' . (is_null($school)? "" : ",".$school->id),
                    ],
                    'college_id' => [
                        'required',
                        'exists:colleges,id',
                    ],
                    'notifications_address' => [
                        'required',
                        'email',
                    ],
                ];
            case 'POST':
                return [
                    'name' => [
                        'required',
                        'min:3',
                        'unique:schools,name'
                    ],
                    'college_id' => [
                        'required',
                        'exists:colleges,id',
                    ],
                    'notifications_address' => [
                        'required',
                        'email',
                    ],
                ];
        }
    }
}
