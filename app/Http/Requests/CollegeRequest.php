<?php

namespace App\Http\Requests;

use App\Models\College;
use Illuminate\Foundation\Http\FormRequest;

class CollegeRequest extends FormRequest
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
                $college = College::where('name', $this->name)->first();
                return [
                    'name' => [
                        'required',
                        'min:3',
                        'unique:colleges,name' . (is_null($college)? "" : ",".$college->id),
                    ],
                ];
            case 'POST':
                return [
                    'name' => [
                    'required',
                    'min:3',
                    'unique:colleges,name'
                    ],
                ];
        }
    }
}
