<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class CreateResidentRequest extends FormRequest
{

    
    /**
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // $this->user
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
            'name'=> 'string|required|min:3',
            'email'=> 'string|required|unique:users',
            'email_verified_at'=>'nullable',
            'password'=> 'required|string|min:5',
            'phone_number'=> 'string|required',
            'age'=> 'numeric|required|min:15',
            'job_title'=> 'required',
            'role' => 'required|regex:/user/i',
        ];
    }
}
