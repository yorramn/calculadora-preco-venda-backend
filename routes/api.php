<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')
    ->as('auth:auth')
    ->controller(\App\Http\Controllers\Api\Auth\AuthController::class)
    ->group(function () {
        Route::post('register', 'register');
        Route::post('login', 'login');
        Route::post('logout', 'logout')->middleware('auth:sanctum');
    });


Route::middleware(['auth:sanctum'])
    ->group(function () {
        Route::prefix('categories')
            ->as('categories:categories')
            ->apiResource('categories', \App\Http\Controllers\Api\Category\CategoryController::class);

        Route::prefix('quotes')
            ->as('quotes:quotes')
            ->apiResource('quotes', \App\Http\Controllers\Api\Quote\QuoteController::class);

        Route::prefix('plans')
            ->as('plans:plans')
            ->apiResource('plans', \App\Http\Controllers\Api\Plan\PlanController::class);

        Route::put('quotes/{id}/change-status', [\App\Http\Controllers\Api\Quote\QuoteController::class, 'change_status']);

        Route::prefix('products')
            ->as('products:products')
            ->controller(\App\Http\Controllers\Api\Product\ProductController::class)
            ->group(function () {
                Route::get('', 'index');
                Route::post('', 'store');
            });
    });

