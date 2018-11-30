<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\DentalUsers;

class CheckLogoutTest extends TestCase
{
    public function testResetTimeResponse()
    {
        $user = factory(DentalUsers::class)->create();

        $response = $this->json('GET', '/api/dental-users/check-logout/' . $user->userid);

        $user->delete();

        $response->assertJsonStructure([
            'reset_time'
        ]);
    }

    public function testLogoutResponse()
    {
        $user = factory(DentalUsers::class)->create([
            'last_accessed_date' => date('Y-m-d H:i:s', strtotime('-1 hours'))
        ]);

        $response = $this->json('GET', '/api/dental-users/check-logout/' . $user->userid);

        $user->delete();

        $response->assertJson([
            'logout' => true,
        ]);
    }
}
