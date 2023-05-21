<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardUserController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\UserSettingsController;
use App\Http\Controllers\AbsenController;
use App\Http\Controllers\RekapanPresensiController;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\KonfigurasiController;

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
                    Route::get('/', 'index');
                });
                Route::middleware('user')->group(function () {
                    Route::controller(DashboardUserController::class)->group(function () {
                        Route::get('/user', 'index')->name('.user');
                    });
                });
                Route::middleware('admin')->group(function () {
                    Route::controller(DashboardAdminController::class)->group(function () {
                        Route::name('.admin')->group(function () {
                            Route::prefix('/admin')->group(function () {
                                Route::get('/', 'index');
                            });
                        });
                    });
                    Route::controller(KonfigurasiController::class)->group(function () {
                        Route::name('.setting.')->group(function () {
                            Route::prefix('/setting')->group(function () {
                                Route::get('/hariLibur', 'hariLibur')->name('hariLibur');
                                Route::post('/hariLibur/store', 'hariLiburStore')->name('hariLibur.store');
                                Route::delete('/hariLibur/delete/{id}', 'hariLiburDelete')->name('hariLibur.delete');
                                Route::get('/lokasi', 'lokasi')->name('lokasi');
                                Route::post('/lokasi/update', 'lokasiUpdate')->name('lokasi.update');
                                Route::get('/absen', 'jamHari')->name('absen');
                                Route::get('/absen/{id}', 'jamHariSetting')->name('absen.setting');
                                Route::put('/absen/{id}/update', 'jamHariSettingUpdate')->name('absen.update');
                            });
                        });
                    });
                });
                Route::controller(AbsenController::class)->group(function () {
                    Route::name('.presensi')->group(function () {
                        Route::get('/presensi/absen', 'index')->name('.absen');
                        Route::post('/presensi/absen/store', 'absen')->name('.absen.store');
                    });
                });
                Route::controller(IzinController::class)->group(function () {
                    Route::name('.pengajuan')->group(function () {
                        Route::middleware('admin')->group(function(){
                            Route::get('/pengajuan/pending', 'pending')->name('.pending');
                            Route::patch('/pengajuan/izin/konfirmasi', 'konfirmasi')->name('.konfirmasi');
                            Route::get('/pengajuan/disetujui', 'disetujui')->name('.disetujui');
                            Route::get('/pengajuan/ditolak', 'ditolak')->name('.ditolak');
                        });
                    });
                    Route::name('.presensi')->group(function () {
                        Route::get('/presensi/izin', 'index')->name('.izin');
                        Route::post('/presensi/izin/store', 'store')->name('.izin.store');
                        Route::get('/presensi/izin/show/{id}', 'show')->name('.izin.show');
                    });
                });
                Route::controller(RekapanPresensiController::class)->group(function () {
                    Route::name('.rekapan')->group(function () {
                        Route::get('/rekapan', 'index')->name('');
                            Route::middleware('admin')->group(function (){
                                Route::get('/rekapan/hariIni', 'hariIni')->name('.hariIni');
                                Route::get('/rekapan/guru', 'guru')->name('.guru');
                                Route::get('/rekapan/guru/{id}', 'showGuru')->name('.show.guru');
                                Route::get('/rekapan/tanggal', 'tanggal')->name('.tanggal');
                            });
                    });
                });
                Route::controller(UserSettingsController::class)->group(function () {
                    Route::name('.profile')->group(function () {
                        Route::get('/profile', 'index')->name('');
                        Route::patch('/profile/update', 'update')->name('.update');
                        Route::patch('/ubah/kata-sandi', 'changePassword')->name('.changePassword');
                    });
                });
            });
        });
    });
});
