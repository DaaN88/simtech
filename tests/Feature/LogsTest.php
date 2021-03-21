<?php

namespace Tests\Feature;

use App\Models\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

class LogsTest extends TestCase
{
    /**
     * The method tests the complete cleaning of logs from the database
    */
    public function testClearAllLogs(): void
    {
        Passport::actingAs(
            User::factory()->create(),
            ['create-servers', 'access-logs']
        );
        $payload = [];

        $this->json('DELETE', '/api/admin/log/clear', $payload)
            ->assertStatus(200)
            ->assertJson(['result' => 'success']);

        User::whereNotNull('email_verified_at')->delete();
    }
}
