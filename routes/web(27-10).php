<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/orders', [OrderController::class, 'index'])->name('orders');
Route::get('/reset-filters', [OrderController::class, 'resetFilters'])->name('reset-filters');
Route::get('/orderinfo/{id}', [ProductController::class, 'index'])->name('orderinfo');
Route::get('/mis-overview', [OrderController::class, 'MISOverview'])->name('MIS-overview');
Route::get('/download-csv', [OrderController::class, 'downloadCSV'])->name('downloadCsv');
Route::post('send-otp',[LoginRegisterController::class,'SendOTP'])->name('send-otp');
Route::post('check-otp',[LoginRegisterController::class,'CheckOTP'])->name('check-otp');
Route::post('get-sbd-data', [OrderController::class, 'getSbdData'])->name('get-sbd-data');
Route::get('/sbd-mis-overview', [OrderController::class, 'SBDMISOverview'])->name('sbd-mis-overview');