<?php

namespace App\Http\Requests;

use App\Rules\CheckOldPassword;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class PasswordRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $password = new Password(8);
        $password->numbers();
        return [
            'old_password' => ['required', new CheckOldPassword],
            'password'     => ['required', 'confirmed', $password],
        ];
    }
}
