<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\ChucVuController;


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


Route::get('/', function(){
    return view('login');
})->name('login');
Route::get('/login', [AuthenticateController::class, 'login'])->name('login');
Route::post('/login-process', [AuthenticateController::class, 'loginProcess'])->name('login-process');  

Route::get('/dashboard', function(){
    return view('dashboard');
})->name('dashboard');

route::get('/chuc-vu', [ChucVuController::class, 'index']);
Route::get('/chuc-vu/list', [ChucVuController::class, 'list'])->name('chuc-vu');
Route::post('/chuc-vu/add', [ChucVuController::class, 'store'])->name('chuc-vu-add');
Route::post('/chuc-vu/edit', [ChucVuController::class, 'edit'])->name('chuc-vu-edit');


