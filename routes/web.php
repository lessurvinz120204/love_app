<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

Route::get('/', fn() => redirect('/login'));
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

// Admin routes
Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
Route::post('/admin/upload', [AdminController::class, 'upload']);
Route::delete('/admin/delete/{id}', [AdminController::class, 'delete']);

// User routes
Route::get('/user/dashboard', [UserController::class, 'dashboard']);
Route::get('/user/category/{type}', [UserController::class, 'category']);