<?php

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RequestCodeController;
use App\Http\Controllers\WebhookController;
use App\Http\Requests\RegisterRequest;
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


Route::post("request-code", [RequestCodeController::class, 'requestCode'])->middleware('throttle:request-code');
Route::post("register", [RegisterController::class, 'register']);
Route::get("users", [RegisterController::class, 'getUser']);
Route::post("webhook/update-status", [WebhookController::class, 'updateStatus']);