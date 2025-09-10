<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
   public function rules(): array
{
    // Récupère l'ID de l'utilisateur si on est en édition
    $userId = optional($this->route('user'))->id;

    $rules = [
        'name' => 'required|string|max:255',
        'email' => [
            'required',
            'email',
            Rule::unique('users', 'email')->ignore($userId),
        ],
        'status' => 'required|in:ACTIVE,INACTIVE,BLOCKED',
        'role_id' => 'required|exists:roles,id'

    ];

    // Password uniquement lors de la création
    if ($this->method() === 'POST') {
        $rules['password'] = 'required|min:8|confirmed';
    }

    return $rules;
}

}
