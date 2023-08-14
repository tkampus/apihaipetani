<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\appController;
use App\Http\Controllers\API\faqController;
use App\Http\Controllers\API\chatController;
use App\Http\Controllers\API\profilController;
use App\Http\Controllers\API\bookmarkController;
use App\Http\Controllers\API\imgController;
use App\Models\event;

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


Route::controller(appController::class)->group(function () {
    // login dan register
    Route::post('register', 'daftar');
    Route::post('login', 'masuk');
    // event
    Route::post('getevent', 'getevent');
});
// faq
Route::post('getfaq', [faqController::class, 'get']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    // logout
    Route::post('logout', [appController::class, 'keluar']);
    // ganti password
    Route::post('resetpassword', [appController::class, 'resetpassword']);
    // masukan
    Route::post('setmasukan', [appController::class, 'setmasukan']);
    // profil
    Route::post('getprofil', [profilController::class, 'get']);
    Route::post('upprofil', [profilController::class, 'up']);
    // bookmark
    Route::post('setbookmark', [bookmarkController::class, 'set']);
    Route::post('getbookmark', [bookmarkController::class, 'get']);
    Route::post('delbookmark', [bookmarkController::class, 'del']);
    // chat
    Route::post('getallchat', [chatController::class, 'getriwayat']);
    Route::post('getahli', [chatController::class, 'getahli']);
    // pesan
    Route::post('getchat', [chatController::class, 'getchat']);
    Route::post('setchat', [chatController::class, 'setchat']);
});


// tester scantum
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// tester input gambar
Route::post('inpugambar', [imgController::class, 'inpugambar']);
