<?php

use App\Http\Controllers\AbsensiKaryawanController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
    return redirect('/home');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/profile', 'ProfileController@index')->name('profile');
Route::put('/profile', 'ProfileController@update')->name('profile.update');

Route::middleware('auth')->group(function () {
    Route::get('/absen', [AbsensiKaryawanController::class, 'index'])->name('absen.index');
    Route::post('/absen', [AbsensiKaryawanController::class, 'store'])->name('absen.store');

    Route::get('/rekapabsen', [UserController::class, 'rekapAbsenUser'])->name('rekapabsen.index');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('user', UserController::class);

    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingsController::class, 'store'])->name('settings.store');

    Route::resource('department', DepartmentController::class);

    Route::get('/absensi', [AbsensiKaryawanController::class, 'showAllAbsensi'])->name('absensi.showAllAbsensi');
    Route::get('/export', [AbsensiKaryawanController::class, 'export'])->name('absensi.export');

    Route::get('/user/{user}/export', [UserController::class, 'exportByUser'])->name('absensi.exportByUser');
});
