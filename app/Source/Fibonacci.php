<?php

namespace App\Source;

class Fibonacci
{
    protected $cache = [0 => 0, 1 => 1];

    /**
     * Recursive method - calculate fibonacci numbers
     *
     * @param $number - expected only integer
     *
     *
     */
    public function calculate(int $number)
    {
        if (! isset($this->cache[$number])) {
            $this->cache[$number] = $this->calculate($number - 1)
                + $this->calculate($number - 2);
        }

        return $this->cache[$number];
    }
}
