<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Source\Fibonacci;

class FibonacciTest extends TestCase
{
    /**
     * @var Fibonacci
    */
    protected $fibonacci;

    public function setUp(): void
    {
        $this->fibonacci = new Fibonacci();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCalculate()
    {
        $right_result = $this->fibonacci->calculate('5');
        $number_less_than_two = $this->fibonacci->calculate('1');

        // in fact the maximum number is 1450, but the maximum nesting level is 256, so the check is 100
        $max_number = $this->fibonacci->calculate('100');

        self::assertEquals(5, $right_result);
        self::assertEquals(1, $number_less_than_two);
        self::assertEquals(3.54224848179262E+20, $max_number);
    }
}
