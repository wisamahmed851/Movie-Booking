<?php

use App\Http\Controllers\api\{
    AuthController,
    HomeController,
    UserController,
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserController::class, 'index']);
});
Route::get('/home', [HomeController::class, 'index']);
Route::get('/details/{id}', [HomeController::class, 'details']);
