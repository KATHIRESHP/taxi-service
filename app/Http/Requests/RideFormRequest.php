<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RideFormRequest extends FormRequest
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
            'source_latitude' => 'required',
            'source_longitude' => 'required',
            'destination_latitude' => 'required',
            'destination_longitude' => 'required',
            'location' => 'required',
            'time' => 'required|date_format:H:i',
        ];
    }
}
