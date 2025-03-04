<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Services\AuthServices;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ApiAuthController extends Controller
{
    public function __construct(protected AuthServices $authServices)
    {
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $newUser = $request->validated();
        $newUser['email_verified_at'] = now();
        $newUser['remember_token'] = Str::random(10);
        $user = User::create($newUser);
        try {
            $token = $this->authServices->getPassportToken($request->input('email'), $request->input('password'));
            $user['token'] = $token;

            return response()->json($user, 200);
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
    public function login(LoginRequest $request): JsonResponse
    {
        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            $user = Auth::user();

            try {
                $token = $this->authServices->getPassportToken($request->input('email'), $request->input('password'));
                $user['token'] = $token;

                return response()->json($user, 200);
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
     * Return auth user data
     */
    public function me(): JsonResponse
    {
        $me = Auth::user();

        return response()->json(compact('me'), 200);
    }

    /**
     * logout the user
     */
    public function revokeToken(): JsonResponse
    {
        Auth::user()->token()->revoke();

        return response()->json([
            'message' => 'Token revoked',
        ], 200);

    }
}
