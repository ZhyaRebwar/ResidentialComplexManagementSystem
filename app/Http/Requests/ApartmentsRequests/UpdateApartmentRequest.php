<?php

namespace App\Http\Requests\ApartmentsRequests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateApartmentRequest extends FormRequest
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
            'floor' => 'number',
            'name' => 'string',
            'electricity_unit'=> 'numeric',
            'owner_id'=> 'nullable',
        ];
    }
}
