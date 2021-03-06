<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogCategoryCreateRequest extends FormRequest
{
    public function authorize()
    {
//        return auth()->check();
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|min:5|max:200',
            'slug' => 'max:200',
            'description' => 'string|min:3|max:500',
            'parent_id' => 'integer|required|exists:blog_categories,id',
        ];
    }
}
