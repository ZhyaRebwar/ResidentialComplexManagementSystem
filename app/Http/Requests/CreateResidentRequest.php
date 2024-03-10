<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;


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
        if(Auth::check()){
            $user = Auth::user();

           // Check if the user has an "admin" role
            $isAdmin = $user->roles()->where('role', 'admin')->exists();

            if ($isAdmin) {
                // User has admin role
                return true;
            }
            }
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
            'name'=> 'string|required|min:3',
            'email'=> 'string|required|unique:users',
            'email_verified_at'=>'nullable',
            'password'=> 'required|string|min:5',
            'phone_number'=> 'string|required',
            'age'=> 'numeric|required|min:15',
            'job_title'=> 'required',
        ];
    }
}
