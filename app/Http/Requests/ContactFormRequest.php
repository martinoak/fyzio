<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class ContactFormRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|min:9',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Jméno je povinné pole.',
            'email.required' => 'Email je povinné pole.',
            'email.email' => 'Email musí být ve správném formátu.',
            'phone.required' => 'Telefon je povinné pole.',
            'phone.min' => 'Telefon musí mít alespoň 9 znaků.',
        ];
    }

    public function getRedirectUrl(): string
    {
        return parent::getRedirectUrl() . '#contact';
    }
}
