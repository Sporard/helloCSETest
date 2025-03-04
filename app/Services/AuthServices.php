<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;

class AuthServices
{
    /**
     * Call Passport api to get access token
     *
     * @throws Exception
     */
    public function getPassportToken(string $email, string $password): string
    {
        $response = Http::post(env('APP_URL').'/oauth/token', [
            'grant_type' => 'password',
            'client_id' => env('PASSPORT_PASSWORD_CLIENT_ID'),
            'client_secret' => env('PASSPORT_PASSWORD_SECRET'),
            'username' => $email,
            'password' => $password,
            'scope' => '',
        ]);

        if ($response->successful()) {
            return $response->json();
        }
        throw new Exception('Invalid credentials.');
    }

    /**
     * Call Passport Api to refresh a token
     *
     * @throws Exception
     */
    public function refreshToken(string $refreshToken): bool
    {
        $response = Http::asForm()->post(env('APP_URL').'/oauth/token', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
            'client_id' => env('PASSPORT_PASSWORD_CLIENT_ID'),
            'client_secret' => env('PASSPORT_PASSWORD_SECRET'),
            'scope' => '',
        ]);
        if ($response->successful()) {
            return $response->json()['access_token'];
        }
        throw new Exception('Unable to refresh token.');
    }
}
