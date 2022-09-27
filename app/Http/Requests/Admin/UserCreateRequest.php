<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth('web')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => [
                'required',
                'email',
                'string',
                'unique:users,email'
            ],
            'name' => [
                'required',
                'string',
                'unique:users,name',
                'min:3'
            ],
            'password' => [
                'required',
                'confirmed',
                'min:6'
            ],
        ];
    }
}
