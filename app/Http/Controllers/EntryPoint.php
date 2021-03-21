<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Source\Fibonacci;
use App\Source\Dns;
use App\Source\Logs;

class EntryPoint extends BaseController
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function fibonacci(Request $request): \Illuminate\Http\JsonResponse
    {
        $fibonacci = new Fibonacci();

        $number = $request->input('number');

        return $fibonacci->calculate($number);
    }

    public function dns(Request $request)
    {
        $dns = new Dns();

        $domain = $request->input('domain');
        $type = strtoupper($request->input('type'));

        return $dns->get($domain, $type);
    }

    public function getLog()
    {
        $logs = new Logs();

        return $logs->getAll();
    }

    public function clearLog()
    {
        $logs = new Logs();

        return $logs->clear();
    }
}
