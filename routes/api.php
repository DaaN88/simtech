<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\Fibonacci;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->post('/fibonacci', [Fibonacci::class, 'calculate']);

Route::middleware('auth:api')->post('/dns', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:api')->get('/admin/log', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:api')->delete('/admin/log/clear', function (Request $request) {
    return $request->user();
});
