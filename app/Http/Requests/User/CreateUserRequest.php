<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'full_name' => 'required|string',
            'phone' => ['required', 'regex:/^(?:\+?84|0)(?:\d){9,10}$/'],
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|confirmed|min:6|max:64',
            'roles' => 'nullable|array',
            'roles.*' => [
                Rule::exists('roles', 'name'),
            ],
        ];
    }
}
