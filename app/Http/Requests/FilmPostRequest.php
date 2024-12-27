<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilmPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'          => ['required', 'string'],
            'link_poster'   => ['file', 'mimes:jpeg,jpg,png,webp,svg', 'max:5000'],
            'genre'         => ['required', 'string']
        ];
    }
}
