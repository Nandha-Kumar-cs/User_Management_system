<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
Route::get('/login', function () {
    return view('login');
})->name('login');
Route::get('/register', function () {
    return view('register');
})->name('register');
Route::view('/profile' , 'userProfile');
Route::get('/adminData' , [Admin::class , 'getUsers'])->name('admin/userData');
Route::view('/admin' ,'admin' );
Route::view('/admin/users' , 'adminuserstable');