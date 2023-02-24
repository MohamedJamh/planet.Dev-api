<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $method = $this->method();
        if ($method === 'PUT') {
            return [
                'title' => ['required'],
                'body' => ['required'],
                'userId' => ['required'],
                'categoryId' => ['required'],
            ];
        } else {
            return [
                'title' => ['sometimes', 'required'],
                'body' => ['sometimes', 'required'],
                'userId' => ['sometimes', 'required'],
                'categoryId' => ['sometimes', 'required'],
            ];
        }
    }

    protected function prepareForValidation()
    {
        $this->userId ? $this->merge(['user_id' => $this->userId]) : null;
        $this->categoryId ? $this->merge(['category_id' => $this->categoryId]) : null;
    }
}
