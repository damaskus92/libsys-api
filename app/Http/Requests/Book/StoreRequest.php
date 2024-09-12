<?php

namespace App\Http\Requests\Book;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'        => 'required|string',
            'description'  => 'required|string',
            'publish_date' => 'required|date|date_format:Y-m-d',
            'author_id'    => 'required|exists:authors,id',
        ];
    }
}
