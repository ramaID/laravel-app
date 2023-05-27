<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'description' => 'nullable',
        ];
    }

    public function bodyParameters()
    {
        return [
            'name' => [
                'description' => 'Nama kategori',
            ],
            'description' => [
                'description' => 'Deskripsi kategori',
                'required' => false,
            ],
        ];
    }
}
