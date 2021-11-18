<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
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
            'name' => ['required', 'string', 'between:2,100'],
            'surname' => ['required', 'string', 'between:2,100'],
            'patronymic' => ['nullable', 'string', 'between:2,100'],
            'phone' => ['required', 'integer'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
            'iin' => ['required', 'string', 'max:12'],
            'gpa' => ['nullable'],
            'parent_phone' => ['required', 'integer'],
            'group_id' => ['required', 'integer'],
        ];
    }
}
