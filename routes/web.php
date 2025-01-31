<?php

use App\Http\Controllers\AssignMovieController;
use App\Http\Controllers\AssignMoviesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\CinemaController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ComentBlogController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckRole;
use App\Http\Middleware\Guest;
use App\Http\Middleware\ValidUser;
use App\Models\ComentBlog;

Route::controller(AuthController::class)->prefix('auth')->group(function () {
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

            Route::controller(CityController::class)->prefix('city')->group(function () {
                Route::get('/', 'index')->name('city.index');
                Route::post('/status/{id}', 'status')->name('city.status'); // Changed {user} to {id}
                Route::get('/create', 'create')->name('city.create');
                Route::post('/store', 'store')->name('city.store');
                Route::get('/edit/{id}', 'edit')->name('city.edit'); // Added edit route
                Route::post('/update/{id}', 'update')->name('city.update'); // Added update route
            });
            Route::controller(MovieController::class)->prefix('movies')->group(function () {
                Route::get('/', 'index')->name('movies.index');
                Route::post('/status/{id}', 'status')->name('movies.status'); // Changed {user} to {id}
                Route::get('/create', 'create')->name('movies.create');
                Route::post('/store', 'store')->name('movies.store');
                Route::get('/edit/{id}', 'edit')->name('movies.edit'); // Added edit route
                Route::post('/update/{id}', 'update')->name('movies.update'); // Added update route
            });
            Route::controller(CinemaController::class)->prefix('cinemas')->group(function () {
                Route::get('/', 'index')->name('cinemas.index');
                Route::post('/status/{id}', 'status')->name('cinemas.status'); // Changed {user} to {id}
                Route::get('/create', 'create')->name('cinemas.create');
                Route::post('/store', 'store')->name('cinemas.store');
                Route::get('/edit/{id}', 'edit')->name('cinemas.edit'); // Added edit route
                Route::post('/update/{id}', 'update')->name('cinemas.update'); // Added update route
            });
            Route::controller(AssignMoviesController::class)->prefix('assign/movies')->group(function () {
                Route::get('/', 'index')->name('assign.movies.index');
                Route::post('/status/{id}', 'status')->name('assign.movies.status'); // Changed {user} to {id}
                Route::get('/create', 'create')->name('assign.movies.create');
                Route::post('/store', 'store')->name('assign.movies.store');
                Route::get('/edit/{id}', 'edit')->name('assign.movies.edit'); // Added edit route
                Route::post('/update/{id}', 'update')->name('assign.movies.update'); // Added update route
            });
            Route::controller(BlogsController::class)->prefix('blogs')->group(function () {
                Route::get('/', 'index')->name('blogs.index');
                Route::post('/status/{id}', 'status')->name('blogs.status'); // Changed {user} to {id}
                Route::get('/create', 'create')->name('blogs.create');
                Route::post('/store', 'store')->name('blogs.store');
                Route::get('/edit/{id}', 'edit')->name('blogs.edit'); // Added edit route
                Route::put('/update/{id}', 'update')->name('blogs.update'); // Added update route
            });
            Route::controller(ComentBlogController::class)->prefix('comments')->group(function () {
                Route::post('/index', 'index')->name('comments.index');
                Route::post('/status{id}', 'status')->name('comments.status');
                Route::post('/approved{id}', 'approved')->name('comments.approved');
                Route::post('/edit{id}', 'edit')->name('comments.edit');
                Route::post('/update{id}', 'update')->name('comments.update');
                Route::get('/{id}', 'show')->name('comments.show');
                Route::post('/approve{id}', 'approve')->name('comments.approve');
            });
            Route::controller(ComentBlogController::class)->prefix('comments')->group(function () {
                Route::get('/', 'index')->name('comments.index');
                Route::post('/status/{id}', 'status')->name('comments.status'); // Changed {user} to {id}
                Route::get('/create', 'create')->name('comments.create');
                Route::get('/edit/{id}', 'edit')->name('comments.edit'); // Added edit route
                Route::put('/update/{id}', 'update')->name('comments.update'); // Added update route
            });
        });
    }

);
Route::middleware([ValidUser::class])->group(
    function () {
        Route::controller(UserController::class)->prefix('profile')->group(function () {
            Route::get('/', 'profile')->name('user.profile');
            Route::post('/update-info', 'updateInfo')->name('user.updateInfo');
        });
    }
);
Route::prefix('')->group(
    function () {
        Route::controller(FrontController::class)->prefix('')->group(function () {
            Route::get('/', 'index')->name('front.index');
        });
        Route::controller(ComentBlogController::class)->prefix('comments')->group(function () {
            Route::post('/store', 'store')->name('comments.store');
        });
        Route::controller((PageController::class))->prefix('')->group(function () {
            Route::get('/about-Us', 'about')->name('pages.about');
            Route::get('/contact', 'contact')->name('pages.contact');
            Route::post('/contact/store', 'store')->name('pages.contact.store');
        });
        Route::controller(BlogsController::class)->prefix('blogs')->group(function () {
            Route::get('/list', 'list')->name('blogs.list');
            Route::get('/details/{id}', 'details')->name('blogs.details');
        });
        Route::controller(MovieController::class)->prefix('movies')->group(function () {
            Route::get('/list', 'list')->name('movies.grid');
            Route::get('/loadmovies', 'loadmovies')->name('movies.loadmovies');
            Route::get('/details/{id}', 'details')->name('movies.details');
        });
        Route::controller(UserController::class)->prefix('user')->group(function () {
            Route::get('/login', 'loginform')->name('user.login')->middleware(Guest::class);
            Route::post('/loginstore', 'login')->name('user.login.store')->middleware(Guest::class);
            Route::get('/logout', 'logout')->name('user.logout');

            Route::get('/forgotpassword', 'forgotpassword')->name('user.forgotpassword');
            Route::post('/send-otp', 'sendOTP')->name('user.send.otp');
            Route::get('/verify-otp', 'showVerifyOTPForm')->name('user.otp.form');
            Route::post('/verify-otp', 'verifyOTP')->name('user.verify.otp');

            Route::get('/resend-otp', 'resendOTP')->name('user.resend.otp');

            Route::get('/resetpassword/{token}', 'resetpasswordForm')->name('user.password.reset');
            Route::post('/reset-password', 'resetPassword')->name('user.password.update');

            Route::post('/update-password', 'updatePassword')->name('user.updatePassword');

            Route::get('/register', 'registerForm')->name('user.register');
            Route::post('/registerstore', 'store')->name('user.register.store');
        });
    }
);
