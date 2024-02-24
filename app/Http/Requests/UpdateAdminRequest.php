<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
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
            'name'=> 'string|min:3',
            'email'=> 'string|unique:users',
            'email_verified_at'=>'nullable',
            'password'=> 'string|min:5',
            'phone_number'=> 'string',
            'age'=> 'numeric|min:15',
            'role'=> 'string|in:admin,both'
            // 'job_title'=> ''
        ];
    }
}
