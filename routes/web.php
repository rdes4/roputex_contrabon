<?php

use App\Http\Controllers\AccessController;
use App\Http\Controllers\ContrabonController;
use App\Http\Controllers\HtmlController;
use App\Http\Controllers\MasterData\BankController;
use App\Http\Controllers\MasterData\CustomerController;
use App\Http\Controllers\MasterData\SalesController;
use Illuminate\Support\Facades\Route;

Route::get('/akses', [AccessController::class, 'form_akses'])->name('akses.form');
Route::post('/akses', [AccessController::class, 'verify_akses'])->name('akses.verify');

Route::middleware(['akses'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::prefix('master-data')->group(function () {

        Route::prefix('customer')->group(function () {
            Route::post('ajax-data', [CustomerController::class, 'ajax_data']);
            Route::post('create', [CustomerController::class, 'create']);
            Route::post('save', [CustomerController::class, 'save']);
            Route::post('edit', [CustomerController::class, 'edit']);
            Route::post('update', [CustomerController::class, 'update']);
            Route::post('delete', [CustomerController::class, 'delete']);
        });

        Route::prefix('bank')->group(function () {
            Route::post('ajax-data', [BankController::class, 'ajax_data']);
            Route::post('create', [BankController::class, 'create']);
            Route::post('save', [BankController::class, 'save']);
            Route::post('edit', [BankController::class, 'edit']);
            Route::post('update', [BankController::class, 'update']);
            Route::post('delete', [BankController::class, 'delete']);
        });

        Route::prefix('sales')->group(function () {
            Route::post('ajax-data', [SalesController::class, 'ajax_data']);
            Route::post('create', [SalesController::class, 'create']);
            Route::post('save', [SalesController::class, 'save']);
            Route::post('edit', [SalesController::class, 'edit']);
            Route::post('update', [SalesController::class, 'update']);
            Route::post('delete', [SalesController::class, 'delete']);
        });

    });

    Route::post('/get-tab-html', [HtmlController::class, 'get_tab_html']);

    Route::prefix('contrabon')->group(function () {
        Route::post('ajax-data', [ContrabonController::class, 'ajax_data']);
        Route::post('save', [ContrabonController::class, 'save']);
        Route::post('edit', [ContrabonController::class, 'edit']);
        Route::post('update', [ContrabonController::class, 'update']);
        Route::post('delete', [ContrabonController::class, 'delete']);
        Route::post('print-selection', [ContrabonController::class, 'print_selection']);
        Route::get('print', [ContrabonController::class, 'print']);
    });

});
