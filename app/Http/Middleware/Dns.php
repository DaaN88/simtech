<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Dns
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

        if (! $request->type) {
            $error['error'] = "Type is empty. Enter type DNS";
            return response($error)
                ->header('Content-Type', 'application/json');
        }

        if (! $request->domain) {
            $error['error'] = "Domain is empty. Enter Domain name";
            return response($error)
                ->header('Content-Type', 'application/json');
        }

        if (is_numeric($request->type)) {
            $error['error'] = "{$request->type} is wrong type. Please enter right type";
            return response($error)
                ->header('Content-Type', 'application/json');
        }

        if (is_numeric($request->domain)) {
            $error['error'] = "{$request->domain} is wrong domain. Please enter right domain";
            return response($error)
                ->header('Content-Type', 'application/json');
        }

        $allowed_dns_types = [
            'A',
            'A6',
            'AAAA',
            'AFSDB',
            'AVC',
            'CAA',
            'CNAME',
            'DNAME',
            'DNSKEY',
            'DS',
            'HINFO',
            'ISDN',
            'KEY',
            'KX',
            'LOC',
            'MB',
            'MG',
            'MINFO',
            'MR',
            'MX',
            'NAPTR',
            'NULL',
            'NS',
            'NSAP',
            'NSEC',
            'NSEC3',
            'NSEC3PARAM',
            'PTR',
            'PX',
            'RP',
            'RRSIG',
            'RT',
            'SIG',
            'SOA',
            'SRV',
            'SSHFP',
            'TKEY',
            'TLSA',
            'TSIG',
            'TXT',
            'WKS',
            'X25',
        ];

        if (! in_array(strtoupper($request->type), $allowed_dns_types, true)) {
            $error['error'] = "{$request->type} is incorrect type. Please enter correct type";
            return response($error)
                ->header('Content-Type', 'application/json');
        }

        return $next($request);
    }
}
