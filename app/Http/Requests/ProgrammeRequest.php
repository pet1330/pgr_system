<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\Programme;

class ProgrammeRequest extends FormRequest
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
                $programme = Programme::where('name', $this->name)->first();
                return [
                    'name' => [
                        'required',
                        'min:3',
                        'unique:programmes,name' . (is_null($programme)? "" : ",".$programme->id),
                    ],
                    'duration' => [
                        'required',
                        'numeric',
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
                    'unique:programmes,name'
                    ],
                    'duration' => [
                        'required',
                        'numeric',
                        'integer',
                        'min:1',
                        'max:600',
                    ],
                ];
        }
    }
}
