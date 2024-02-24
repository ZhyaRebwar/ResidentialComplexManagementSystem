<?php

namespace App\Http\Requests\ApartmentsRequests;

use Illuminate\Foundation\Http\FormRequest;

class CrateApartmentRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

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
            'floor' => 'required|numeric',
            'name' => 'required|string',
            'electricity_unit' => 'required|numeric',
            'building_id' => 'required',
            'owner_id'=> 'nullable',
        ];
    }
}
