<?php

namespace Tests\Feature;

use App\Models\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

class FibonacciTest extends TestCase
{
    /**
     * The method tests normal class work @see \App\Source\Fibonacci
     *
     * @return void
     */
    public function testFibonacciApi()
    {
        // it's from documentation
        Passport::actingAs(
            User::factory()->create(),
            ['create-servers']
        );

        $payload = [
            'number' => 5,
        ];

        $this->json('POST', '/api/fibonacci', $payload)
            ->assertStatus(200)
            ->assertJsonFragment(['result' => 5]);

        User::whereNotNull('email_verified_at')->delete();
    }

    /**
     * @dataProvider additionalProvidersWrongArguments
     *
     *
     */
    public function testFibonacciApiOnError($arguments, $responses)
    {
        Passport::actingAs(
            User::factory()->create(),
            ['create-servers']
        );

        self::json('POST', '/api/fibonacci', $arguments)
            ->assertStatus(200)
            ->assertJsonFragment($responses);

        User::whereNotNull('email_verified_at')->delete();
    }

    public function additionalProvidersWrongArguments()
    {
        return [
            'null_number' => [
                [
                    'number' => '',
                ],
                [
                    'error' => 'Number can\'t be null',
                ]
            ],
            'not_numeric' => [
                [
                    'number' => 'adsd',
                ],
                [
                    'error' => 'adsd not a number. Please enter number',
                ]
            ],
            'float_number' => [
                [
                    'number' => 5.5,
                ],
                [
                    'error' => '5.5 not an integer. Please enter an integer',
                ]
            ],
            'negative_number' => [
                [
                    'number' => -10,
                ],
                [
                    'error' => '-10 is negative number. Please enter a positive number',
                ]
            ],
            'high_number' => [
                [
                    'number' => 99999999999999,
                ],
                [
                    'error' => 'Number 99999999999999 is too high. Please Enter a number up to 1450 inclusive',
                ]
            ],
        ];
    }
}
