<?php

namespace App\Source;

class Fibonacci
{
    /**
     * Recursive method - calculate fibonacci numbers
     *
     * @param $number - expected only integer
     *
     * @return int
     */
    public function calculate(int $number): int
    {
        if ($number < 2) {
            return $number;
        }

        return $this->calculate($number - 1) + $this->calculate($number - 2);
    }
}
