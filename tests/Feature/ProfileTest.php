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

    Passport::actingAs(User::factory()->make());
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

test('get a profile unauthenticated', closure: function () {
    /** @var Profile $testProfile */
    $testProfile = Profile::factory()->create();

    $response = $this->get('/api/profiles/'.$testProfile->id);
    $response->assertStatus(200);
    $response->assertJsonIsObject(key: 'data');

    $response->assertJson(function (AssertableJson $json) {
        $json->has(key: 'data');
        $json->whereAllType([
            'data.id' => 'integer',
            'data.last_name' => 'string',
            'data.first_name' => 'string',
            'data.image' => 'string',
        ]);
        $json->missing('status');
    });
});
test('get a profile authenticated', closure: function () {
    /** @var Profile $testProfile */
    $testProfile = Profile::factory()->create();
    Passport::actingAs(User::factory()->make());
    $response = $this->get('/api/profiles/'.$testProfile->id);
    $response->assertStatus(200);
    $response->assertJsonIsObject(key: 'data');

    $response->assertJson(function (AssertableJson $json) {
        $json->has(key: 'data');
        $json->whereAllType([
            'data.id' => 'integer',
            'data.last_name' => 'string',
            'data.first_name' => 'string',
            'data.image' => 'string',
            'data.status' => 'string',
        ]);
    });
});
