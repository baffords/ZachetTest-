<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateArticle extends FormRequest
{
    public function authorize()
    {
    return true;
    }

    public function rules()
    {
        return [
            'text'=>"required",
            'short_text'=>"required",
            'author_name'=>"required"

        ];
    }
}
