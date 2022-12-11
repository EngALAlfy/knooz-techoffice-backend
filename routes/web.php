<?php


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

Route::get('/login', [UserController::class, 'showLogin'])->middleware('guest');
Route::post('/login', [UserController::class, 'login'])->middleware('guest')->name('login');
Route::get('/logout', [UserController::class, 'logout'])->middleware('auth')->name('logout');

