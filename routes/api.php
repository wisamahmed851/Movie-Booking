<?php

use App\Http\Controllers\api\{
    AuthController,
    HomeController,
    MovieController,
    UserController,
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('')->group(
    function () {

        // login and register routes
        Route::controller(AuthController::class)->group(function () {
            Route::post('/register', 'register');
            Route::post('/login', 'login');
        });
        // authenticated routes
        Route::middleware('auth:sanctum')->group(function () {
            Route::controller(UserController::class)->prefix('user')->group(function () {
                Route::get('/', 'index');
            });
            Route::controller(MovieController::class)->prefix('movies')->group(function () {
                Route::post('/ticket-plan/{id}', 'ticketplan');
            });
        });



        Route::controller(HomeController::class)->prefix('')->group(function () {
            Route::get('/', 'index');
            Route::post('/filter', 'filter');
        });
        Route::controller(MovieController::class)->prefix('movies')->group(
            function () {
                Route::post('/list', 'movies');
                Route::post('/loadmovies', 'loadMovies');
                Route::get('details/{id}', 'details');
            }
        );
    }
);
