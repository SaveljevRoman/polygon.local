<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogPostCreateRequest extends FormRequest
{
    public function authorize()
    {
//        return auth()->check();
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|min:5|max:200|unique:blog_posts',
            'slug' => 'max:200',
            'content_raw' => 'required|string|min:5|max:10000',
            'category_id' => 'required|integer|exists:blog_categories,id',
        ];
    }

    public function messages()
    {
        return [
            //локализация лежит в ресурсах
            'title.required' => 'Введите заголовок статьи',
            'content_raw.min' => 'Введите заголовок Минимальная длина статьи [:min] символов',
        ];
    }

    public function attributes()
    {
        return [
          'title' => 'Заголовок'
        ];
    }
}
