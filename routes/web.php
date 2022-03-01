<?php

use App\Http\Controllers\AuthController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login',[AuthController::class, 'index']);
Route::post('/login',[AuthController::class, 'authenticate']);
Route::middleware(['auth','admin'])->group(function () {
    Route::get('/admin', function () {
        return view('dashboard.admin');
    });
});
Route::get('/dashboard', function () {
    return view('dashboard.member');
});
