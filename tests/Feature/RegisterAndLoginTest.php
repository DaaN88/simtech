<?php

namespace Tests\Feature;

use App\Models\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

class RegisterAndLoginTest extends TestCase
{
    public function testRegisterAsUser()
    {
        Passport::actingAs(
            User::factory()->create(),
            ['create-servers']
        );

        $payload = [
            'name' => 'testUser',
            'email' => 'test_user@gmail.com',
            'password' => 'testuser1234'
        ];

        $this->json('POST', '/api/register', $payload)
            ->assertStatus(200);

        User::where('name', 'testUser')->delete();
        User::whereNotNull('email_verified_at')->delete();
    }
}
