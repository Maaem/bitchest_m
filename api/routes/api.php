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

Route::middleware("auth:sanctum")->group(function () {
    Route::get("/user", function (Request $request) {
        return $request->user()->role;
    });
    Route::controller(\App\Http\Controllers\ClientController::class)->group(function () {
        Route::get("/me", "index");
        Route::get("/me/{currency}", "show");
    });
    Route::controller(\App\Http\Controllers\WalletController::class)->group(function () {
        Route::get("wallet", "show");
    });
    Route::resource("users", \App\Http\Controllers\UserController::class);
    Route::resource("currency", \App\Http\Controllers\CurrencyController::class)->only([
        "index",
        "show",
    ]);
    Route::delete("/crypto-wallet/{crypto_wallet:currency_id}", [
        \App\Http\Controllers\CryptoWalletController::class,
        "delete",
    ]);
    Route::resource("crypto-wallet", \App\Http\Controllers\CryptoWalletController::class)->only([
        "store",
        "show",
    ]);
});

Route::controller(\App\Http\Controllers\AuthController::class)->group(function () {
    Route::post("/login", "login");
    Route::get("/logout", "logout");
});
