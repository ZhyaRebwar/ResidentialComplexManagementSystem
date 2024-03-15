<?php

namespace App\Http\Requests\Repairment\User;

use Illuminate\Foundation\Http\FormRequest;

class CreateRepairmentRequest extends FormRequest
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
            'repairment_components' => 'required|in:pluming,electronic wires,electronic devices,indoor building',
            'description' => 'required',
            'picture' => 'nullable',
            'type' => 'required|in:houses,apartments',
            'property_id' => 'required'
        ];
    }
}
