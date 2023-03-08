<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\UserSettingsController;
use App\Http\Controllers\PresensiController;

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

Route::get('/', function () {
    return view('welcome');
});
Route::middleware('revalidate')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::controller(LoginController::class)->group(function () {
            Route::get('/login', 'login')->name('login');
            Route::post('/authenticate', 'authenticate')->name('authenticate');
        });
        Route::controller(RegisterController::class)->group(function () {
            Route::get('/register', 'register')->name('register');
            Route::post('/registration', 'registration')->name('registration');
        });
        Route::controller(ForgotPasswordController::class)->group(function () {
            Route::get('/forgot-password', 'forgotPassword')->name('forgotPassword');
            Route::post('/forgotPasswordProcess', 'forgotPasswordProses')->name('forgotPasswordProses');
        });
        Route::controller(ResetPasswordController::class)->group(function () {
            Route::get('/reset-password/{token}', 'resetPassword')->name('resetPassword');
            Route::post('/reset-password', 'resetPasswordProcess')->name('resetPasswordProcess');
        });
    });
    Route::middleware('auth')->group(function () {
        Route::post('/logout', [DashboardController::class, 'logout'])->name('logout');
        Route::prefix('dashboard')->group(function () {
            Route::name('dashboard')->group(function () {
                Route::controller(DashboardController::class)->group(function () {
                    Route::get('/', 'index')->name('');
                    Route::get('/user', 'indexUser')->name('.user');
                });
                Route::controller(PresensiController::class)->group(function () {
                    Route::get('user/presensi', 'index')->name('.user.presensi');
                });
                Route::controller(UserSettingsController::class)->group(function () {
                    Route::get('user/settings', 'index')->name('.user.settings');
                });
            });
        });
    });
});
