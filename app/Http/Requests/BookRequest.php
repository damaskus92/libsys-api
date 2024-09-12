<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            /**
             * @example Lorem ipsum dolor sit amet
             */
            'title' => 'required|string',
            /**
             * @example Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.
             */
            'description' => 'required|string',
            /**
             * @example 2000-10-02
             */
            'publish_date' => 'required|date|date_format:Y-m-d',
            /**
             * @example 1
             */
            'author_id' => 'required|exists:authors,id',
        ];
    }
}
