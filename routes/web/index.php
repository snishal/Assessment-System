<?php

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


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->prefix('user')->group(base_path('routes/web/user_routes.php'));

Route::middleware(['auth', 'admin'])->prefix('admin')->group(base_path('routes/web/admin_routes.php'));

Route::get('/home', 'HomeController@index')->name('home');
