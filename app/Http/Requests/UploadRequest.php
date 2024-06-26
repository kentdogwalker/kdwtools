<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class UploadRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'clients_file' => 'required|file|mimes:csv,txt|max:2048',
            'vets_file' => 'required|file|mimes:csv,txt|max:2048',
            'pets_file' => 'required|file|mimes:csv,txt|max:2048',
        ];
    }

    public function withValidator(Validator $validator)
    {
        if ($validator->fails()) {
            alert()->error('Error', 'The file must be filled in and in CSV format.');
        }
    }
}
