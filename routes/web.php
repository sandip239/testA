<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\authcontroller;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('register',[authcontroller::class,'registerView'])->name('registerView');
Route::post('register',[authcontroller::class,'register'])->name('register');
Route::get('login',[authcontroller::class,'loginView'])->name('loginview');
Route::post('login',[authcontroller::class,'login'])->name('login');

Route::get('register-view',[AdminController::class,'index'])->name('form-view');
Route::post('register-data',[Admincontroller::class,'registerData'])->name('form-data');

Route::get('user-data',[Admincontroller::class,'Userdata'])->name('user-data');

Route::get('edit-user/{id}',[Admincontroller::class,'editUser'])->name('edit-user');
Route::post('update-user',[Admincontroller::class,'updateUser'])->name('update-user');