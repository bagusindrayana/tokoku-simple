<?php

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

Route::get('/', [App\Http\Controllers\WelcomeController::class, 'index'])->name('welcome');

Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'index'])->name('login');
    Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'loginAction'])->name('login.action');
});
Route::group(['prefix' => 'my-panel', 'middleware' => 'auth', 'as' => 'my-panel.'], function () {
    Route::get('/', [App\Http\Controllers\MyPanel\HomeController::class, 'index'])->name('home');
    Route::get('/logout', [App\Http\Controllers\Auth\LogoutController::class, 'logout'])->name('logout');

    Route::get('product', [App\Http\Controllers\MyPanel\ProductController::class, 'index'])->name('product.index');
});
