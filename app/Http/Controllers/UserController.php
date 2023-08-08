<?php

namespace App\Http\Controllers;

use App\Http\Requests\Todo\StoreRequest;
use App\Http\Requests\User\IndexRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param IndexRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(IndexRequest $request): AnonymousResourceCollection
    {
        $users = User::all();

        return UserResource::collection($users);
    }

    /**
     * Display the specified resource.
     * @param User $user
     * @return UserResource
     */
    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        return new UserResource($user);
    }
}
