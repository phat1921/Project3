<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\BangLuongController;
use App\Http\Controllers\ChucVuController;
use App\Http\Controllers\DiaDiemIpController;
use App\Http\Controllers\HopDongController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\NhanVienController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\CheckLogged;
use App\Http\Middleware\CheckLogin;

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
Route::middleware([CheckLogged::class])->group(function(){
    Route::get('/login', [AuthenticateController::class, 'login'])->name('login');
    Route::post('/login-process', [AuthenticateController::class, 'loginProcess'])->name('login-process');  
});    

// Route::middleware([CheckLogin::class])->group(function(){
//     Route::get('/calendar', function(){
//         return view('calendar');
//     })->name('calendar');

Route::middleware([CheckLogin::class])->group(function(){
        Route::get('/chamcong', function(){
            return view('chamcong');
        })->name('chamcong');

    Route::get('/logout',[AuthenticateController::class, 'logout'])->name('logout');

    route::get('/chuc-vu', [ChucVuController::class, 'index'])->name('chucvu');
    Route::get('/chuc-vu/list', [ChucVuController::class, 'list'])->name('chuc-vu');
    Route::post('/chuc-vu/add', [ChucVuController::class, 'store'])->name('chuc-vu-add');
    Route::get('/chuc-vu/load/{id}', [ChucVuController::class, 'load'])->name('chuc-vu-load');
    Route::post('/chuc-vu/edit/{id}', [ChucVuController::class, 'edit'])->name('chuc-vu-edit');
    Route::post('/chuc-vu/del/{id}', [ChucVuController::class, 'del'])->name('chuc-vu-del');

    route::get('/nhan-vien', [NhanVienController::class, 'index'])->name('nhanvien');
    Route::get('/nhan-vien/list', [NhanVienController::class, 'list'])->name('nhan-vien');
    Route::post('/nhan-vien/add', [NhanVienController::class, 'store'])->name('nhan-vien-add');
    Route::get('/nhan-vien/load/{id}', [NhanVienController::class, 'load'])->name('nhan-vien-load');
    Route::post('/nhan-vien/edit/{id}', [NhanVienController::class, 'edit'])->name('nhan-vien-edit');
    Route::post('/nhan-vien/del/{id}', [NhanVienController::class, 'del'])->name('nhan-vien-del');
    Route::post('/nhan-vien/image/{id}', [NhanVienController::class, 'uploadImage'])->name('nhan-vien-image');

    route::get('/tai-khoan', [NhanVienController::class, 'taikhoan'])->name('taikhoan');
    Route::get('/tai-khoan/getTK', [NhanVienController::class, 'getTK'])->name('tai-khoan');
    Route::get('/tai-khoan/staff', [NhanVienController::class, 'listStaff'])->name('getStaff');
    Route::get('/tai-khoan/ip', [NhanVienController::class, 'listIp'])->name('getIp');
    Route::get('/tai-khoan/loadTK/{id}', [NhanVienController::class, 'loadTK'])->name('tai-khoan-load');
    Route::post('/tai-khoan/addTK', [NhanVienController::class, 'addTK'])->name('tai-khoan-add');
    Route::post('/tai-khoan/editTK/{id}', [NhanVienController::class, 'editTK'])->name('tai-khoan-edit');
    Route::post('/tai-khoan/del/{id}', [NhanVienController::class, 'delTK'])->name('nhan-vien-del');
    // Route::post('/nhan-vien/image/{id}', [NhanVienController::class, 'uploadImage'])->name('nhan-vien-image');

    route::get('/hop-dong', [HopDongController::class, 'index'])->name('hopdong');
    Route::get('/hop-dong/list', [HopDongController::class, 'list'])->name('hop-dong');
    Route::post('/hop-dong/add', [HopDongController::class, 'store'])->name('hop-dong-add');
    Route::get('/hop-dong/load/{id}', [HopDongController::class, 'load'])->name('hop-dong-load');
    Route::post('/hop-dong/edit/{id}', [HopDongController::class, 'edit'])->name('hop-dong-edit');
    Route::post('/hop-dong/del/{id}', [HopDongController::class, 'del'])->name('hop-dong-del');
    Route::get('/hop-dong/staff', [HopDongController::class, 'listStaff'])->name('getStaff');
    Route::get('/hop-dong/role', [HopDongController::class, 'listRole'])->name('getRole');


    route::get('/truy-cap', [DiaDiemIpController::class, 'index'])->name('truycap');
    Route::get('/truy-cap/list', [DiaDiemIpController::class, 'list'])->name('truy-cap');
    Route::post('/truy-cap/add', [DiaDiemIpController::class, 'store'])->name('truy-cap-add');
    Route::get('/truy-cap/load/{id}', [DiaDiemIpController::class, 'load'])->name('truy-cap-load');
    Route::post('/truy-cap/edit/{id}', [DiaDiemIpController::class, 'edit'])->name('truy-cap-edit');
    Route::post('/truy-cap/del/{id}', [DiaDiemIpController::class, 'del'])->name('truy-cap-del');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/list', [ProfileController::class, 'list'])->name('profile-list');
    Route::post('/profile/upavatar', [ProfileController::class, 'upAvatar'])->name('profile-image');
    Route::post('/profile/edit', [ProfileController::class, 'edit'])->name('profile-edit');
    Route::post('/profile/changepass', [ProfileController::class, 'changePass'])->name('profile-changepass');

    Route::post('/index/checkin', [IndexController::class, 'checkIn'])->name('checkin');
    Route::post('/index/checkout', [IndexController::class, 'checkOut'])->name('checkout');
    Route::get('/index/list', [IndexController::class, 'list'])->name('cham_cong');

    Route::get('/bang-luong', [BangLuongController::class, 'index'])->name('bangluong');
    Route::get('/bang-luong/list', [BangLuongController::class, 'list'])->name('bang-luong-list');
    Route::get('/bang-luong/load/{id}', [BangLuongController::class, 'load'])->name('bang-luong-load');
    Route::post('/bang-luong/edit/{id}', [BangLuongController::class, 'edit'])->name('bang-luong-edit');
    Route::post('/bang-luong/add', [BangLuongController::class, 'add'])->name('bang-luong-add');
    Route::post('/bang-luong/checkall', [BangLuongController::class, 'checkall'])->name('bang-luong-checkall');
    Route::post('/bang-luong/uncheck/{id}', [BangLuongController::class, 'uncheck'])->name('bang-luong-uncheck');
    Route::post('/bang-luong/checkbyid/{id}', [BangLuongController::class, 'checkById'])->name('bang-luong-checkbyid');
    Route::get('/bang-luong/search', [BangLuongController::class, 'search'])->name('bang-luong-search');
});

