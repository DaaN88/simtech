<?php

namespace App\Source;

use App\Models\LogsModel;

class Logs
{
    public function getAll()
    {
        $logs = LogsModel::all();

        $response = [
            'result' => $logs,
        ];

        return response()->json($response, 200);
    }

    public function clear()
    {
        LogsModel::truncate();

        $response = [
            'result' => 'success',
        ];

        return response()->json($response, 200);
    }
}
