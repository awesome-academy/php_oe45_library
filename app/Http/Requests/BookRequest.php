<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
            'book_title' => 'required|max:255',
            'book_desc' => 'required',
            'quantity' => 'required',
            'cate_id' => 'required',
            'author_id' => 'required',
            'pub_id' => 'required',
        ];
    }
}
