<?php

use App\Models\Profile;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Passport\Passport;

test('get all profiles unauthenticated', closure: function () {
    $response = $this->get('/api/profiles');

    $response->assertStatus(200);
    $response->assertJsonIsArray(key: 'data');

    $response->assertJson(function (AssertableJson $json) {
        $json->has(key: 'data', callback: function (AssertableJson $json) {
            $json->whereAllType([
                'id' => 'integer',
                'last_name' => 'string',
                'first_name' => 'string',
                'image' => 'string',
            ]);
            $json->missing('status');
        });
    });
});

test('get all profiles authenticated', closure: function () {

    Passport::actingAs(User::factory()->create());
    $response = $this->get('/api/profiles');

    $response->assertStatus(200);
    $response->assertJsonIsArray(key: 'data');

    $response->assertJson(function (AssertableJson $json) {
        $json->has(key: 'data', callback: function (AssertableJson $json) {
            $json->whereAllType([
                'id' => 'integer',
                'last_name' => 'string',
                'first_name' => 'string',
                'image' => 'string',
                'status' => 'string',
            ]);
        });
    });
});
