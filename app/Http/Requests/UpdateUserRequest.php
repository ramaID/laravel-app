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
        /** @var User */
        $user = $this->route('user');

        $rules = parent::rules();
        $rules['data.attributes.email'] = 'sometimes|required|string|email|unique:users,email,' . $user->id;
        $rules['data.attributes.password'] = 'nullable';

        return $rules;
    }

    public function update(): bool
    {
        /** @var User */
        $user = $this->route('user');

        /** @var array<string, mixed> $attributes */
        $attributes = $this->input('data.attributes');

        return (bool) $user->query()->update($attributes);
    }
}
