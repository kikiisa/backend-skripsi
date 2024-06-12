<?php

use App\Http\Controllers\Api\ApiProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookApiController;
use App\Http\Controllers\Api\KategoriApiController;
use App\Http\Controllers\Api\SliderApiController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\Api\PeminajamanApiController;
use App\Http\Controllers\AprioriController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('login',AuthController::class)->name('login');
Route::post('register',[AuthController::class,'register'])->name('register');
Route::get('kategori',[KategoriApiController::class,'index']);
Route::get('kategori/{id}',[KategoriApiController::class,'getKategoriById']);

Route::get('slider',[SliderApiController::class,'index']);

Route::resource('buku-api',BookApiController::class);
Route::get('search-buku/{id}',[BookApiController::class,'search']);

Route::put('transaksi-buku/{id}',[PeminjamanController::class,'changeStatus'])->name('transaksi.update');
Route::get('my-transaksi/{id}',[PeminajamanApiController::class,'index']);

Route::get('algoritma-apriori',[AprioriController::class,'index']);


Route::put('ubah-password',[ApiProfileController::class,'update']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
