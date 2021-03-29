<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLogin'])->name('auth.login');
Route::post('/', [AuthController::class, 'authenticate'])->name('auth.login');
Route::get('/logout', [AuthController::class, 'showLogout'])->name('auth.logout');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::get('/register', [AuthController::class, 'showRegister'])->name('auth.register');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');

Route::get('/email-password-reset', [AuthController::class, 'showPwReset'])
  ->middleware('guest')->name('password.reset.email');
Route::post('/email-password-reset', [AuthController::class, 'postPwResetEmail'])
  ->middleware('guest')->name('password.reset.email');

Route::get('/password-reset', [AuthController::class, 'showPwResetForm'])->name('password.reset');
Route::post('/password-reset', [AuthController::class, 'updatePassword'])
  ->name('password.update');

Route::get('/note', [AppController::class, 'show'])->middleware('auth')->name('app.note');
Route::post('/note', [AppController::class, 'update'])->middleware('auth')->name('app.note');
Route::get('/private-uploads/images/{any}', [FileController::class, 'getFile'])
  ->middleware('auth')->name('app.private-uploads.images');
