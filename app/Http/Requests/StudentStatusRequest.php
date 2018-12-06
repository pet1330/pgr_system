<?php

namespace App\Http\Requests;

use App\Models\StudentStatus;
use Illuminate\Foundation\Http\FormRequest;

class StudentStatusRequest extends FormRequest
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
        switch ($this->method()) {
            case 'DELETE':
            return [];
            case 'PATCH':
            case 'PUT':
                $status = StudentStatus::where('status', $this->status)->first();

                return [
                    'status' => [
                        'required',
                        'min:2',
                        'unique:student_statuses,status'.(is_null($status) ? '' : ','.$status->id),
                    ],
                ];
            case 'POST':
                return [
                    'status' => [
                        'required',
                        'min:2',
                        'unique:student_statuses,status',
                    ],
                ];
        }
    }
}
