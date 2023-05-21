<?php

namespace App\Http\Requests;

use App\Models\User;

class UpdateUserRequest extends CreateUserRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = parent::rules();
        $rules['data.attributes.email'] = 'sometimes|required|string|email|unique:users,email,' . $this->user->id;
        $rules['data.attributes.password'] = 'nullable';

        return $rules;
    }

    public function update(): bool
    {
        /** @var User */
        $user = $this->route('user');

        return $user->update($this->input('data.attributes'));
    }
}
