<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ProductController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::get('/get/products', [ProductController::class, 'index']);
Route::middleware('auth:sanctum')->post('/create/product', [ProductController::class, 'store']);
Route::middleware('auth:sanctum')->post('/update/product/{id}', [ProductController::class, 'update']);
Route::middleware('auth:sanctum')->delete('/delete/product/{id}', [ProductController::class, 'destroy']);