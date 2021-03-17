<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Fibonacci extends BaseController
{
    public function calculate(Request $request)
    {
        return response()->json('OK', 200);
    }
}
