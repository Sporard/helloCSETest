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

}
