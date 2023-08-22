<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\ExcelController;

Route::get('/tests', function () {

})->name('welcome');

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/createReport', [ReportsController::class, 'createReport'])->name('createReport');
        Route::post('/store', [ReportsController::class, 'store'])->name('reports.store');

        Route::get('/endCreateReport', [ReportsController::class, 'endCreateReport'])
            ->name('endCreateReport');

        Route::post('/reports/selectMonth', [ReportsController::class, 'selectMonth'])
            ->name('reports.selectMonth');

        Route::get('/reports', [ReportsController::class, 'index'])->name('reports');
        Route::post('/reports/edit', [ReportsController::class, 'edit'])->name('reports.edit');
        Route::post('/reports/update', [ReportsController::class, 'update'])->name('reports.update');
        Route::get('/reports/find/{id?}', [ReportsController::class, 'find'])->name('reports.find');
        Route::get('/reports/delete/{id?}', [ReportsController::class, 'delete'])->name('reports.delete');

        Route::get('/excel', [ExcelController::class, 'index'])->name('excel');
        Route::post('/excel/getMonths', [ExcelController::class, 'getMonths'])->name('excel.getMonths');
        Route::post('/excel/generate', [ExcelController::class, 'generate'])->name('excel.generate');
        Route::get('/excel/download/{fileName?}', [ExcelController::class, 'download'])->name('excel.download');
    });
});

Route::prefix('auth')->controller(AuthController::class)->name('auth.')->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::get('/register', 'register')->name('register');
    Route::get('/logout', 'logout')->name('logout');
});
