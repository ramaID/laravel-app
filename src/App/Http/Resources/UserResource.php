<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->ulid,
            'type' => 'users',
            'attributes' => [
                'name' => $this->name,
                'email' => $this->email,
                'created_at' => $this->created_at->toJSON(),
                'updated_at' => $this->updated_at->toJSON(),
            ],
        ];
    }
}
