<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleValidate extends FormRequest
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
        $articleId = $this->route()->parameter('id');
 
        return [
            'name' => 'required|unique:articles, name,' . $articleId,
            'body' => 'required|min:5'
        ];
    }
}
