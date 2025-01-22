<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\LanguageController;
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
                Route::get('/create', 'create')->name('users.create');
                Route::post('/store', 'store')->name('users.store');
                Route::post('/togglerole/{user}', 'togglerole')->name('user.togglerole');
            });
            Route::controller(GenreController::class)->prefix('genres')->group(function () {
                Route::get('/', 'index')->name('genres.index');
                Route::post('/status/{id}', 'status')->name('genres.status'); // Changed {user} to {id}
                Route::get('/create', 'create')->name('genres.create');
                Route::post('/store', 'store')->name('genres.store');
                Route::get('/edit/{id}', 'edit')->name('genres.edit'); // Added edit route
                Route::post('/update/{id}', 'update')->name('genres.update'); // Added update route
            });
            Route::controller(LanguageController::class)->prefix('languages')->group(function () {
                Route::get('/', 'index')->name('languages.index');
                Route::post('/status/{id}', 'status')->name('languages.status'); // Changed {user} to {id}
                Route::get('/create', 'create')->name('languages.create');
                Route::post('/store', 'store')->name('languages.store');
                Route::get('/edit/{id}', 'edit')->name('languages.edit'); // Added edit route
                Route::post('/update/{id}', 'update')->name('languages.update'); // Added update route
            });
            Route::controller(MovieContoller::class)->prefix('movies')->group(function () {
                Route::get('/', 'index')->name('movies.index');
                Route::post('/status/{id}', 'status')->name('movies.status'); // Changed {user} to {id}
                Route::get('/create', 'create')->name('movies.create');
                Route::post('/store', 'store')->name('movies.store');
                Route::get('/edit/{id}', 'edit')->name('movies.edit'); // Added edit route
                Route::post('/update/{id}', 'update')->name('movies.update'); // Added update route
            });
        });
        Route::prefix('')->group(
            function () {
                Route::controller(FrontController::class)->prefix('')->group(function () {
                    Route::get('/', 'index')->name('front.index');
                });
                Route::controller(MovieContoller::class)->prefix('movies')->group(function () {
                    Route::get('/list', 'list')->name('movies.grid');
                    Route::get('loadmovies', 'loadmovies')->name('movies.loadmovies');
                    Route::get('/details/{id}', 'details')->name('movies.details');
                });
                Route::controller(UserController::class)->prefix('user')->group(function (){
                    Route::get('/login', 'loginform')->name('user.login');
                    Route::post('/loginstore', 'login')->name('user.login.store');
                    Route::get('/register', 'registerForm')->name('user.register');
                    Route::post('/loginstore', 'store')->name('user.register.store');
                });
            }
        );
    }
);
