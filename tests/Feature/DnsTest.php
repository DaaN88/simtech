<?php

namespace Tests\Feature;

use App\Models\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

class DnsTest extends TestCase
{
    public function testDnsApi()
    {
        Passport::actingAs(
            User::factory()->create(),
            ['create-servers']
        );
        $payload = [
            'type' => 'a',
            'domain' => 'ru'
        ];

        // not include 'result' in test because TTL changes every time
        $this->json('POST', '/api/dns', $payload)
            ->assertStatus(200);

        User::whereNotNull('email_verified_at')->delete();
    }

    /**
     * @dataProvider additionalProvidersWrongArguments
     *
     *
    */
    public function testDnsApiOnError($arguments, $responses)
    {
        Passport::actingAs(
            User::factory()->create(),
            ['create-servers']
        );

        self::json('POST', '/api/dns', $arguments)
            ->assertStatus(200)
            ->assertJsonFragment($responses);

        User::whereNotNull('email_verified_at')->delete();
    }

    public function additionalProvidersWrongArguments()
    {
        return [
            'empty_type' => [
                [
                    'type' => '',
                    'domain' => 'ru',
                ],
                [
                    'error' => 'Type is empty. Enter type DNS',
                ]
            ],
            'empty_domain' => [
                [
                    'type' => 'a',
                    'domain' => ''
                ],
                [
                    'error' => 'Domain is empty. Enter Domain name',
                ]
            ],
            'numeric_type' => [
                [
                    'type' => -10,
                    'domain' => 'ru',
                ],
                [
                    'error' => '-10 is wrong type. Please enter right type',
                ]
            ],
            'numeric_domain' => [
                [
                    'type' => 'a',
                    'domain' => 9,
                ],
                [
                    'error' => '9 is wrong domain. Please enter right domain',
                ]
            ],
            'not_allowed_type' => [
                [
                    'type' => 'rt[pfp[dvsdpklf',
                    'domain' => 'ru',
                ],
                [
                    'error' => 'rt[pfp[dvsdpklf is incorrect type. Please enter correct type',
                ]
            ]
        ];
    }
}
