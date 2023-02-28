<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
Route::get('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('/getdata-login', [App\Http\Controllers\HomeController::class, 'index'])->name('getdata-login');

Route::get('/admin/dashboard/{id}/{roles}', [\App\Http\Controllers\TbAdminController::class, 'index'])->name('admin.dashboard');
Route::get('/users/dashboard/{id}/{roles}', [\App\Http\Controllers\TbUserContoller::class, 'index'])->name('users.dashboard');
Route::get('/director/dashboard/{id}/{roles}', [\App\Http\Controllers\TbDirectorController::class, 'index'])->name('director.dashboard');
Route::get('/users-director/{id}/{roles}', [\App\Http\Controllers\UDController::class, 'index'])->name('ud.dashboard');


Route::get('research/{id}/{roles}', [\App\Http\Controllers\TbResearchController::class, 'index'])->name('research-pages');
Route::post('/research/store',[\App\Http\Controllers\TbResearchController::class,'store'])->name('research.store');
