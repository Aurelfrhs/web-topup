<?php

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

Route::middleware('auth:sanctum')->group(function () {

    // Customer Order Routes
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'apiIndex']);
        Route::get('/{id}', [OrderController::class, 'apiShow']);
        Route::post('/', [OrderController::class, 'store']);
    });

});
