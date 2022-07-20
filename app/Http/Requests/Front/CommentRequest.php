<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'text' => [
                'required',
                'string',
                'min:6'
            ],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' => auth('web')->id(),
        ]);
    }
}
