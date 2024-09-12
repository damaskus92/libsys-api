<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthorRequest extends BaseRequest
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
             * @example Damas Eka Kusuma
             */
            'name' => 'required|string',
            /**
             * @example Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.
             */
            'bio' => 'required|string',
            /**
             * @example 1992-09-15
             */
            'birth_date' => 'required|date|date_format:Y-m-d',
        ];
    }
}
