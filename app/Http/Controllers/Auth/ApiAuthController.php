<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ApiAuthController extends Controller
{
    /**
     * Register new user
     */
    public function register(RegisterRequest $request): JsonResponse|UserResource
    {
        $newUser = $request->validated();
        $newUser['email_verified_at'] = now();
        $newUser['remember_token'] = Str::random(10);
        $user = User::create($newUser);
        try {
            $user['token'] = $user->createToken('auth')->accessToken;

            return new UserResource($user);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Login registered user
     * Returns a bearer token
     *
     * @throws Exception
     */
    public function login(LoginRequest $request): JsonResponse|UserResource
    {
        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            /** @var User $user */
            $user = Auth::user();
            try {
                $user['token'] = $user->createToken('auth')->accessToken;

                return new UserResource($user);
            } catch (Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }

        } else {
            return response()->json([
                'message' => 'Failed login',
            ], 401);
        }

    }

    /**
     * refresh the token
     *
     * @throws Exception
     */
    public function refresh(): JsonResponse
    {
        try {
            /** @var User $user */
            $user = Auth::user();
            $user->token()->refreshToken();

            return response()->json('token refreshed', 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Return auth user data
     */
    public function me(): UserResource
    {
        $me = Auth::user();

        return new UserResource($me);
    }

    /**
     * revoke the access token of the user
     */
    public function revokeToken(): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        $user->token()->revoke();

        return response()->json([
            'message' => 'Token revoked',
        ], 200);

    }
}
