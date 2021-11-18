<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'password' => ['required', User::PASSWORD_REGEX],
        ];
    }
}
