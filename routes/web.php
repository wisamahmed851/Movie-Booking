<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\MovieContoller;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckRole;
use App\Http\Middleware\Guest;
use App\Http\Middleware\ValidUser;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::get('/register', 'registerForm')->name('auth.register');
    Route::post('/registerstore', 'register')->name('auth.register.store');
    Route::get('/logout', 'logout')->name('auth.logout');
});
Route::middleware([Guest::class])->group(function () {
    Route::controller(AuthController::class)->prefix('auth')->group(function () {
        Route::get('/login', 'loginform')->name('auth.login');
        Route::post('/loginstore', 'login')->name('auth.login.store');
    });
});
Route::middleware([ValidUser::class, CheckRole::class])->group(
    function () {
        Route::prefix('admin')->group(function () {
            Route::controller(AuthController::class)->prefix('')->group(function () {
                Route::get('/', 'dashboardIndex')->name('dashboard.index');
            });
            Route::controller(UserController::class)->prefix('user')->group(function () {
                Route::get('/', 'index')->name('users.index');
                Route::post('/toggleStatus/{user}', 'toggleStatus')->name('user.toggleStatus');
                Route::post('/togglerole/{user}', 'togglerole')->name('user.togglerole');
                Route::get('/profile', 'profile')->name('users.profile');
                Route::get('/setting', 'setting')->name('users.setting');
            });
        });
        Route::prefix('')->group(
            function () {
                Route::controller(FrontController::class)->prefix('')->group(function () {
                    Route::get('/', 'index')->name('front.index');
                });
                Route::controller((MovieContoller::class))->prefix('movies')->group(function () {
                    Route::get('/grid', 'grid')->name('movies.grid');
                });
            }
        );
    }
);
