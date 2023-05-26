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
        $rules['email'] = 'sometimes|required|string|email';
        $rules['password'] = 'nullable';

        return $rules;
    }

    public function update(): bool
    {
        /** @var User */
        $user = $this->route('user');

        return (bool) $user->query()->update($this->toArray());
    }
}
