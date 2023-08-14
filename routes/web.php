<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WEB\linkcontroller;

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
    return view('welcome');
});

route::get('getimgevent:{id}', [linkcontroller::class, 'getimgevent'])->name('getimgevent');
route::get('getimgchat:{id}', [linkcontroller::class, 'getimgchat'])->name('getimgchat');
route::get('getimgprofil:{role}:{nohp}', [linkcontroller::class, 'getimgprofil'])->name('getimgprofil');
