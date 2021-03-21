<?php

namespace App\Source;

use App\Models\LogsModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Fibonacci
{
    /**
     * Main method who return all data for @see Entry_point::fibonacci()
     * @param $number
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function calculate($number): \Illuminate\Http\JsonResponse
    {
        $result = $this->fib($number);

        $last_inset_id = $this->saveInDb('api/fibonacci', $number);

        $response = [
            'result' => $result,
            'id' => $last_inset_id,
        ];

        return response()->json($response, 200);
    }

    /**
     * Recursive method - calculate fibonacci numbers
     *
     * use in:
     * @see Fibonacci::calculate()
     *
     * @param $number - expected only integer
     *
     * @return int
     */
    private function fib(int $number): int
    {
        if ($number < 2) {
            return $number;
        }

        return $this->fib($number - 1) + $this->fib($number - 2);
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
