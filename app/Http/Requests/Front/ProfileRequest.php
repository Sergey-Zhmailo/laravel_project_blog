<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class ProfileRequest extends FormRequest
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
        $password_validation = [];
        if ($this->request->get('password')) {
            $password_validation = [
                'old-password' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        if (!Hash::check($this->request->get('old-password'), auth('web')->user()->password)) {
                            $fail('The ' . $attribute . ' is invalid.');
                        }
                    },
                    'min:6'
                ],
                'password' => [
                    'required',
                    'confirmed',
                    'min:6'
                ],
            ];
        }

        $image_validation = [
            'avatar-image' => [
                'mimes:jpeg,bmp,png'
            ]
        ];

        return Arr::collapse([$password_validation, $image_validation]);
    }
}
