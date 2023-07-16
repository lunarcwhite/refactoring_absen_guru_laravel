<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Guru\SettingController;
use App\Http\Controllers\Guru\AbsenController;
use App\Http\Controllers\Guru\HistoriAbsenGuruController;
use App\Http\Controllers\Guru\PengajuanIzinController;
use App\Http\Controllers\Admin\RekapanPresensiController;
use App\Http\Controllers\Admin\KelolaIzinController;
use App\Http\Controllers\Admin\KonfigurasiController;

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
        Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
        Route::prefix('/dashboard')->group(function () {
            Route::name('dashboard.')->group(function () {
                Route::controller(DashboardController::class)->group(function () {
                    Route::get('', 'index')->name('index');
                });


                Route::middleware('guru')->group(function () {
                    Route::controller(AbsenController::class)->group(function () {
                        Route::name('absen.')->group(function () {
                            Route::get('/absen', 'index')->name('index');
                            Route::post('/absen/store', 'store')->name('store');
                        });
                    });
                    Route::controller(SettingController::class)->group(function () {
                        Route::name('setting.')->group(function () {
                            Route::get('/setting', 'index')->name('index');
                            Route::patch('/setting/update', 'update')->name('update');
                            Route::patch('/setting/update/kata-sandi', 'change_password')->name('change_password');
                        });
                    });
                    Route::controller(HistoriAbsenGuruController::class)->group(function () {
                        Route::name('histori.')->group(function () {
                            Route::get('/histori', 'index')->name('index');
                        });
                    });
                    Route::controller(PengajuanIzinController::class)->group(function () {
                        Route::name('izin.')->group(function () {
                            Route::get('/izin', 'index')->name('index');
                            Route::post('/izin/store', 'store')->name('store');
                            Route::get('/izin/show/{id}', 'show')->name('show');
                        });
                    });
                });


                Route::middleware('admin')->group(function () {
                    Route::controller(RekapanPresensiController::class)->group(function () {
                        Route::name('rekapan.')->group(function () {
                            Route::get('/rekapan/hariIni', 'hariIni')->name('hariIni');
                            Route::get('/rekapan/guru', 'guru')->name('guru');
                            Route::get('/rekapan/guru/{id}', 'showGuru')->name('show.guru');
                            Route::get('/rekapan/tanggal', 'tanggal')->name('tanggal');
                        });
                        Route::controller(KelolaIzinController::class)->group(function () {
                            Route::name('pengajuan.')->group(function () {
                                Route::get('/pengajuan/pending', 'pending')->name('pending');
                                Route::patch('/pengajuan/izin/konfirmasi', 'konfirmasi')->name('konfirmasi');
                                Route::get('/pengajuan/disetujui', 'disetujui')->name('disetujui');
                                Route::get('/pengajuan/ditolak', 'ditolak')->name('ditolak');
                                Route::get('/pengajuan/show/{id}', 'show')->name('show');
                            });
                        });
                        Route::controller(KonfigurasiController::class)->group(function () {
                            Route::name('setting.')->group(function () {
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
                });



            });
        });
    });
});
