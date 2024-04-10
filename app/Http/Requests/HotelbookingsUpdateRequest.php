<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class HotelbookingsUpdateRequest extends FormRequest
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
            'RoomBookingID' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'RoomBookingID.required' => 'The assign room field is required.'
        ];
    }

    public function withValidator(Validator $validator)
    {
        if ($validator->fails()) {
            alert()->error('Error', 'The data must be entered accurately!');
        }
    }
}
