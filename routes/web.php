<?php

use App\Http\Controllers\ImportController;
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
    return view('welcome');
});
Route::post('/import', [ImportController::class, 'import'])->name('import');
Route::get('/import/status/{importId}', [ImportController::class, 'checkStatus'])->name('import.status');
//Route::get('/import/history', [ImportController::class, 'history'])->name('import.history');
