<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/report', [ApiController::class, 'datareport'])->name('report');
Route::get('/order', [ApiController::class, 'sendOrderDataZypp'])->name('order');
Route::any('/updatestatus', [ApiController::class, 'updateStatusZypp'])->name('updatestatus');
Route::get('/createorder', [ApiController::class, 'createOrderBorzo'])->name('createorder');