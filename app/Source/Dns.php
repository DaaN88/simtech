<?php

namespace App\Source;

use App\Models\LogsModel;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Dns
{
    public function get($domain, $type)
    {
        // https://dns.google/resolve?name={{domain}}&type={{type}}&cd=true&do=true
        $client = new Client();

        $request = "https://dns.google/resolve?name={$domain}&type={$type}&cd=true&do=true";

        try {
            $dns = $client->get($request);
        } catch (GuzzleException $msg) {
            $last_insert_id = $this->saveInDb('api/dns', $request);

            $response = [
                'result' => $msg->getResponse()->getBody()->getContents(),
                'id' => $last_insert_id,
            ];

            return response()->json($response, 200);
        }

        $last_insert_id = $this->saveInDb('api/dns', $request);

        $response = [
            'result' => $dns->getBody()->getContents(),
            'id' => $last_insert_id,
        ];

        return response()->json($response, 200);
    }

    private function saveInDb($api_url, $request)
    {
        DB::beginTransaction();
        $logs = new LogsModel();

        $is_save = $logs
            ->fill([
                'api_url' => $api_url,
                'request' => $request,
                'created_at' => date("Y-m-d H:i:s"),
            ])
            ->save();

        if (! $is_save) {
            Log::critical('Транзакция не выполнена в: ' . self::class);

            DB::rollBack();

            throw new \Exception(
                'Ошибка при транзакции в БД в ' . self::class
            );
        }
        DB::commit();

        return $logs->id;
    }
}
