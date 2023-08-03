<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\ExcelController;

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/reports', [ReportsController::class, 'index'])->name('reports');
        Route::get('/excel', [ExcelController::class, 'index'])->name('excel');
        Route::post('/excel/selectMonth', [ExcelController::class, 'selectMonth'])->name('excel.selectMonth');
        Route::post('/excel/download', [ExcelController::class, 'download'])->name('excel.download');
    });
});

Route::prefix('auth')->controller(AuthController::class)->name('auth.')->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::get('/register', 'register')->name('register');
    Route::get('/logout', 'logout')->name('logout');
});
