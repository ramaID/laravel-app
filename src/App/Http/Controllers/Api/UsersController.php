<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;

final class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): UserCollection
    {
        return new UserCollection(User::query()->paginate(10));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request): JsonResponse
    {
        $user = User::create($request->toArray());

        return (new UserResource($user))
            ->response()
            ->header('Location', route('users.show', compact('user')));
    }

    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $request->update();

        return (new UserResource($user))->response();
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response(null, 204);
    }
}
