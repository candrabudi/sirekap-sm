<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

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
    return redirect('login');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');


Route::get('/home', [HomeController::class, 'index'])->name('user.home');
Route::get('/report', [ReportController::class, 'index'])->name('user.report');
Route::get('/report/success', [ReportController::class, 'reportSuccess'])->name('user.report.success');
Route::get('/tps/list', [ReportController::class, 'listTps'])->name('user.report.listTPS');
Route::get('/tps/detail/{a}', [ReportController::class, 'detailTps'])->name('user.report.detailTps');