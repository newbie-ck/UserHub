<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Default Routes
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('login', [LoginController::class, 'page'])->name('login');
Route::get('register', function () {
    return view('register');
});

// Authentication Routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Admin Management Routes
Route::group(['middleware' => ['auth', 'admin'], 'prefix' => 'admin'], function () {
    Route::prefix('dashboard')->group(function () {
        Route::prefix('data')->group(function () {
            Route::get('users', [UserController::class, 'user_list_index'])->name('admin.users.index');
        });
        Route::prefix('users')->group(function () {
            Route::get('/', [UserController::class, 'user_list_page'])->name('admin.users.page');
            Route::get('generate', [UserController::class, 'generate_users_page'])->name('admin.users.generate.page');
            Route::post('generate', [UserController::class, 'generateDummyUsers']);
            Route::put('deactivate/{user}', [UserController::class, 'deactivate']);
            Route::put('activate/{user}', [UserController::class, 'activate']);
            Route::get('/{user}', [UserController::class, 'profile'])->name('profile');
        });
    });
});

// User Management Routes
Route::middleware('auth')->group(function () {
    Route::post('logout', [UserController::class, 'logout'])->name('logout');
    Route::get('not-admin', [AuthController::class, 'not_admin_page'])->name('not_admin');
    Route::prefix('dashboard')->group(function () {
        Route::get('profile', [UserController::class, 'profile'])->name('profile');
        Route::put('update/{user}', [UserController::class, 'update']);
        Route::put('deactivate/{user}', [UserController::class, 'deactivate']);
    });
    
});