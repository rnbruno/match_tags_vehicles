<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehicleModelRequest extends FormRequest
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
            'id' => ['required', 'integer'],
            'modelo' => ['required', 'string'],
            'tag1' => ['nullable', 'string'],
            'tag2' => ['nullable', 'string'],
            'tag3' => ['nullable', 'string'],
            'tag4' => ['nullable', 'string'],
        ];
    }
}
