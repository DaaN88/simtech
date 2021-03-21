<?php

namespace App\Http\Controllers;

use App\Models\LogsModel;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Source\DataBaseLogSaver;
use GuzzleHttp\Client;
use App\Source\Fibonacci;
use App\Source\Dns;

class EntryPoint extends BaseController
{
    /**
     * Method returns the sum of a sequence of Fibonacci numbers
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function fibonacci(Request $request): \Illuminate\Http\JsonResponse
    {
        $fibonacci = new Fibonacci();
        $log_saver = new DataBaseLogSaver();

        $number = $request->input('number');
        $result = $fibonacci->calculate($number);

        $last_inset_id = $log_saver->saveInDb('api/fibonacci', $number);
        $response = [
            'result' => $result,
            'id' => $last_inset_id,
        ];

        return response()->json($response, 200);
    }

    /**
     * Method returns DNS record
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function dns(Request $request): \Illuminate\Http\JsonResponse
    {
        $client = new Client();
        $log_saver = new DataBaseLogSaver();

        $domain = $request->input('domain');
        $type = strtoupper($request->input('type'));
        $request = "https://dns.google/resolve?name={$domain}&type={$type}&cd=true&do=true";

        $dns = new Dns($client, $request);
        $last_insert_id = $log_saver->saveInDb('api/dns', $request);

        $response = [
            'result' => $dns->get(),
            'id' => $last_insert_id,
        ];

        return response()->json($response, 200);
    }

    /**
     * Method return all logs from DB
    */
    public function getLog(): \Illuminate\Http\JsonResponse
    {
        $logs = LogsModel::all();

        $response = [
            'result' => $logs,
        ];

        return response()->json($response, 200);
    }

    /**
     * Method clear all logs in DB
    */
    public function clearLog()
    {
        LogsModel::truncate();

        $response = [
            'result' => 'success',
        ];

        return response()->json($response, 200);
    }
}
