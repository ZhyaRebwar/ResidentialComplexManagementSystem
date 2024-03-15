<?php

namespace App\Http\Requests\Protest\User;

use Illuminate\Foundation\Http\FormRequest;

class CreateProtestRequest extends FormRequest
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
            'title' => 'required',
            'description' => 'required',
            'compliant' => 'required|in:outdoor,indoor',
            'picture' => 'nullable',
            'type' => 'required|in:houses,apartments',
            'property_id' => 'required',
        ];
    }
}
