<?php

namespace App\Source;

use App\Models\LogsModel;
use Illuminate\Support\Facades\Log;

class DataBaseLogSaver
{
    /**
     * The method saves query data to the database
     *
     * @param $api_url
     * @param $request
     *
     * @return mixed
     * @throws \Exception
     */
    public function saveInDb($api_url, $request)
    {
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

            throw new \Exception(
                'Ошибка при транзакции в БД в ' . self::class
            );
        }

        return $logs->id;
    }
}
