<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Fibonacci
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $error = [];

        if (! $request->number) {
            $error['error'] = "Number can't be null";
            return response($error)
                ->header('Content-Type', 'application/json');
        }

        if (! is_numeric(json_decode($request->number))) {
            $error['error'] = "{$request->number} not a number. Please enter number";
            return response($error)
                ->header('Content-Type', 'application/json');
        }

        if (is_float(json_decode($request->number))) {
            $error['error'] = "{$request->number} not an integer. Please enter an integer";
            return response($error)
                ->header('Content-Type', 'application/json');
        }

        if (json_decode($request->number) < 0) {
            $error['error'] = "{$request->number} is negative number. Please enter a positive number";
            return response($error)
                ->header('Content-Type', 'application/json');
        }

        if (json_decode($request->number) > 1450) {
            $error['error'] = "Number {$request->number} is too high. Please Enter a number up to 1450 inclusive";
            return response($error)
                ->header('Content-Type', 'application/json');
        }

        return $next($request);
    }
}
