<?php
namespace App\Http\Controllers;

use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\StoreRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        $token = auth('api')->attempt($credentials);

        if (!$token) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = auth('api')->user();

        return response()->json([
            'user' => new UserResource($user),
            'token' => $token,
        ]);
    }

    /**
     * @param StoreRequest $request
     * @return UserResource
     */
    public function register(StoreRequest $request): UserResource
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

       return new UserResource($user);
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth('api')->logout();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }
}
