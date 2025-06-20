<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::post('/register', [UserController::class, 'store'])->name('api.register');
Route::post('/login', [UserController::class, 'authenticate'])->name('api.authenticate');
Route::middleware('auth:sanctum')->get('/user/profile', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->post('/logout', function (Request $request) {
    $request->user()->currentAccessToken()->delete();
    return response()->json(['message' => 'Logged out successFully'], 200);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->put('/user/profile' , [UserController::class , 'update'])->name('user.update');

Route::post('/admin/login',[Admin::class , 'login']);

Route::middleware('auth:sanctum')->prefix('/admin')
->group(function(){
   Route::get('/users/{id}', [Admin::class , 'specificUser']);
   Route::delete('/users/{id}', [Admin::class , 'DeleteUser']);
});