<?php

use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Passport\Passport;

test('register user', function () {

    $response = $this->post('/api/register', [
        'email' => 'pest@test.com',
        'password' => 'test',
        'password_confirmation' => 'test',
        'name' => 'test pest',
    ]);

    $response->assertStatus(201);
    $response->assertJsonIsObject(key: 'data');

    $response->assertJson(function (AssertableJson $json) {
        $json->has(key: 'data')
            ->whereAllType([
                'data.id' => 'integer',
                'data.name' => 'string',
                'data.email' => 'string',
                'data.token' => 'string',
            ])
            ->where('data.email', 'pest@test.com')
            ->where('data.name', 'test pest')
            ->missing('data.password');
    });
});
test('login user', function () {

    $response = $this->post('/api/login', [
        'email' => 'test@example.com',
        'password' => 'test',
    ]);

    $response->assertStatus(200);
    $response->assertJsonIsObject(key: 'data');

    $response->assertJson(function (AssertableJson $json) {
        $json->has(key: 'data')
            ->whereAllType([
                'data.id' => 'integer',
                'data.name' => 'string',
                'data.email' => 'string',
                'data.token' => 'string',
                'data.email_verified_at' => 'string',
            ])
            ->where('data.email', 'test@example.com')
            ->where('data.name', 'Test User')
            ->missing('data.password');
    });
});
test('refresh token', function () {
    Passport::actingAs(User::factory()->make());
    $response = $this->post('/api/refresh');

    $response->assertStatus(200);
});
test('refresh token unauth', function () {
    $response = $this->post('/api/refresh');

    $response->assertStatus(401);
});
test('me unauth', function () {
    $response = $this->get('/api/me');

    $response->assertStatus(401);
});
test('me', function () {
    $user = User::factory()->make();
    Passport::actingAs($user);
    $response = $this->get('/api/me');

    $response->assertStatus(200);
    $response->assertJson(function (AssertableJson $json) use ($user) {
        $json->has(key: 'data')
            ->whereAllType([
                'data.name' => 'string',
                'data.email' => 'string',
                'data.email_verified_at' => 'string',
            ])
            ->where('data.email', $user->email)
            ->where('data.name', $user->name);
    });
});
test('revoke token unauth', function () {
    $response = $this->post('/api/token/revoke');

    $response->assertStatus(401);
});
