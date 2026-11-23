<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

/** Profile details or password change, depending on which form was submitted. */
class ProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->isAdmin();
    }

    public function rules(): array
    {
        if ($this->routeIs('admin.profile.password')) {
            return [
                'current_password' => ['required', 'current_password'],
                'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers(), 'different:current_password'],
            ];
        }

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->user()->id)],
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.current_password' => 'Your current password is not correct.',
            'password.different' => 'The new password must be different from the current one.',
        ];
    }
}
