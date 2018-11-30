<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\DentalUsers;
use Mockery;

class CheckLogoutTest extends TestCase
{

    public $dentalUserMock;
    public $userId = 'kirimgan';

    public function setUp()
    {
        parent::setUp();

        $this->dentalUserMock = Mockery::mock(DentalUsers::class);
    }

    public function testResetTimeResponse()
    {
        $this->dentalUserMock->shouldReceive('getLastUserData')
            ->with($this->userId)
            ->once()
            ->andReturn(factory(DentalUsers::class)->make([
                'userid' => $this->userId,
                'last_accessed_date' => date('Y-m-d H:i:s', strtotime('-1 hours'))
            ]));

        $this->app->instance(DentalUsers::class, $this->dentalUserMock);

        $response = $this->json('GET', '/api/dental-users/check-logout/' . $this->userId);

        $response->assertJsonStructure([
            'reset_time'
        ]);
    }

    public function testLogoutResponse()
    {
        $this->dentalUserMock->shouldReceive('getLastUserData')
            ->with($this->userId)
            ->once()
            ->andReturn(factory(DentalUsers::class)->make([
                'userid' => $this->userId,
                'last_accessed_date' => date('Y-m-d H:i:s')
            ]));

        $this->app->instance(DentalUsers::class, $this->dentalUserMock);

        $response = $this->json('GET', '/api/dental-users/check-logout/' . $this->userId);

        $response->assertJson([
            'logout' => true,
        ]);
    }

    public function tearDown() {
        parent::tearDown();
        Mockery::close();
    }
}
