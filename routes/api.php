<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ApiController;
use App\Http\Controllers\API\LineController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('site-setting', [ApiController::class, 'site_setting']);
Route::post('site-setting/update', [ApiController::class, 'yoyaku_setting_update']);

Route::get('yoyaku-timelist/{yoyakutype_category}', [ApiController::class, 'yoyaku_timelist'])->name('yoyaku_timelist');
Route::get('timeinfo-byid/{yoyakujikan}', [ApiController::class, 'timeinfo_byid']);

Route::post('appointment_store', [ApiController::class, 'appointment_store']);
Route::get('appointment-bytokenid/{token_id}', [ApiController::class, 'appointment_bytokenid']);
Route::post('appointment-update', [ApiController::class, 'appointment_update']);
Route::get('appointment-cancel/{token_id}', [ApiController::class, 'appointment_cancel']);

Route::get('yoyakubi_byid/{yoyakubi}', [ApiController::class, 'yoyakubi_byid']);
Route::post('appointment_store_ps', [ApiController::class, 'appointment_store_ps']);


/**
 * yoyaku setting from admin panel
 */
Route::post('yoyakubi_bydate', [ApiController::class, 'yoyakubi_bydate']);
Route::post('yoyakubi_tsupdate', [ApiController::class, 'yoyakubi_tsupdate']);
Route::post('yoyakubi_tsdelete', [ApiController::class, 'yoyakubi_tsdelete']);
Route::post('yoyakubi_tscreate', [ApiController::class, 'yoyakubi_tscreate']);

/**
 * Line Bot testing api
 */
Route::get('line_friends', [LineController::class, 'line_friends']);

