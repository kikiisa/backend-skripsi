<?php

use App\Http\Controllers\AprioriController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SliderController;
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


Route::get('/',[AuthController::class,'index'])->name('auth.login');
Route::post('/',[AuthController::class,'store'])->name('auth.store');
Route::prefix('account')->group(function(){
    Route::middleware('isOperator',)->group(function(){
        Route::get('dashboard',[DashboardController::class,'index'])->name('dashboard');
       

        Route::resource('users',UserController::class);
        Route::put('users-status/{id}',[UserController::class,'updateStatus'])->name('users.status');
        Route::get('logout',[AuthController::class,'logout'])->name('auth.logout');
    
        Route::resource('kategori',KategoriController::class);
        Route::resource('slider',SliderController::class);
        Route::resource('buku',BookController::class);
        Route::resource('profile',ProfileController::class);
        Route::resource('operator',OperatorController::class);
        Route::resource('peminjaman',PeminjamanController::class);
        Route::get("apriori",[AprioriController::class,'show'])->name('apriori');

    });
});