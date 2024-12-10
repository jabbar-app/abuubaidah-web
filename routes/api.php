<?php

use App\Http\Controllers\AzureController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/toggle-status', [AzureController::class, 'toggleStatus']);
