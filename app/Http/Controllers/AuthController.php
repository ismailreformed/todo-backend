<?php

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);

        if (!$token) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();

        return response()->json([
            'user' => new UserResource($user),
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ]
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
        Auth::logout();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }
}
