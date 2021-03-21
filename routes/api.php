<?php

use App\Http\Controllers\PassportAuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EntryPoint;

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

Route::post('register', [PassportAuthController::class, 'register'])->name('registerApi');
Route::post('login', [PassportAuthController::class, 'login'])->name('loginApi');

// Route for admin permissions
Route::prefix('admin')->group(function() {
    Route::post('register', [PassportAuthController::class, 'registerAdmin'])->name('registerAdminApi');
    Route::post('login', [PassportAuthController::class, 'loginAdmin'])->name('loginAdminApi');
});

Route::middleware('auth:api')->group(function () {
    Route::middleware('fibonacci')
        ->post('/fibonacci', [EntryPoint::class, 'fibonacci'])
        ->middleware('fibonacci_response');

    Route::middleware('dns')
        ->post('/dns', [EntryPoint::class, 'dns'])
        ->middleware('dns_response');

    Route::middleware('scope:access-logs')
        ->get('/admin/log', [EntryPoint::class, 'getLog']);

    Route::middleware('scope:access-logs')
        ->delete('/admin/log/clear', [EntryPoint::class, 'clearLog']);
});
