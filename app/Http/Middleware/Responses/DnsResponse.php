<?php

namespace App\Http\Middleware\Responses;

use App\Models\LogsModel;
use Closure;
use Illuminate\Http\Request;

class DnsResponse
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
        $response = $next($request);

        $logs = LogsModel::find($response->original['id']);

        $logs->response = $response;
        $logs->save();

        return $response;
    }
}
