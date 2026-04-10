<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;

// User Register Api
Route::post('/register', [AuthController::class, 'register']);
// User Login Api
Route::post('/login', [AuthController::class, 'login']);
//User Logout Api
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
// Get Users Api
Route::middleware('auth:sanctum')->get('/get/users', [AuthController::class, 'index']);

// Get Products Api
Route::middleware('auth:sanctum')->get('/get/products', [ProductController::class, 'index']);
// Create Products Api
Route::middleware('auth:sanctum')->post('/create/product', [ProductController::class, 'store']);
// Update Products Api
Route::middleware('auth:sanctum')->post('/update/product/{id}', [ProductController::class, 'update']);
// Delete Products Api
Route::middleware('auth:sanctum')->delete('/delete/product/{id}', [ProductController::class, 'destroy']);