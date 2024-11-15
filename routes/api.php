<?php

use App\Http\Controllers\MedicalApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('medical')->group(function () {
    Route::get('/clinics', [MedicalApiController::class, 'getClinics']);
    Route::get('/employees', [MedicalApiController::class, 'getEmployees']);
    Route::get('/nomenclature/{clinicUid}', [MedicalApiController::class, 'getNomenclature']);
    Route::get('/schedule', [MedicalApiController::class, 'getSchedule']);
    Route::get('/order/status/{orderUid}', [MedicalApiController::class, 'getOrderStatus']);
    Route::post('/wait-list', [MedicalApiController::class, 'createWaitList']);
    Route::post('/reserve', [MedicalApiController::class, 'reserveTime']);
    Route::post('/order', [MedicalApiController::class, 'createOrder']);
    Route::delete('/order/{orderUid}', [MedicalApiController::class, 'deleteOrder']);
    Route::post('sms-confirmation', [\App\Http\Controllers\SmsController::class, 'sendCode']);
    Route::post('sms-confirmation/verify', [\App\Http\Controllers\SmsController::class, 'verifySms']);
});
