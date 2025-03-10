<?php

namespace Tests;

use DateTime;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\ClientRepository;

abstract class TestCase extends BaseTestCase
{
    //

    protected $seed = true;

    protected function setUp(): void
    {
        parent::setUp();
        $clientRepository = new ClientRepository;
        $client = $clientRepository->createPersonalAccessClient(
            null, 'Test Personal Access Client', 'http://localhost'
        );

        DB::table('oauth_personal_access_clients')->insert([
            'client_id' => $client->id,
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);
    }
}
