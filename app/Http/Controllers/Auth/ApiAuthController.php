<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ApiAuthController extends Controller
{
    /**
     * Login registered user
     * Returns a bearer token
     */
    public function login(LoginRequest $loginRequest): JsonResponse
    {
        if (Auth::attempt(['email' => $loginRequest->email, 'password' => $loginRequest->password])) {
            $user = Auth::user();
            $response = Http::post(env('APP_URL') . '/oauth/token', [
                'grant_type' => 'password',
                'client_id' => env('PASSPORT_PASSWORD_CLIENT_ID'),
                'client_secret' => env('PASSPORT_PASSWORD_SECRET'),
                'username' => request('email'),
                'password' => request('password'),
                'scope' => '',
            ]);

            $user['token'] = $response->json()['access_token'];

            return response()->json($user, 200);

        } else {
            return response()->json([
                'message' => 'Unauthorized',
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
