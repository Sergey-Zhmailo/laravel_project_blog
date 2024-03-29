<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class PostUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title'       => [
                'required',
                'min:3',
                'max:200',
            ],
            'slug'        => [
                'max:200',
            ],
            'content'     => [
                'required',
                'min:5',
                'max:10000',
            ],
            'excerpt'     => [
                'max:500',
            ],
            'category_id' => [
                'required',
                'integer',
                'exists:post_categories,id',
            ],
            'tag_ids'     => [
                'required',
                'array',
            ],
            'tag_ids.*'   => [
                'integer',
                'exists:post_tags,id',
            ],
            'image.*'     => [
                'mimes:jpeg,bmp,png,jpg',
                'max:5000',
            ],
        ];
    }
}
