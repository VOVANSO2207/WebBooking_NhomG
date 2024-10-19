<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
});
Route::get('/search_result', function () {
    return view('search_result');
});


// Admin - Home
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::prefix('admin')->group(function () {
    // Route cho danh sách phòng
    Route::get('/room', [RoomController::class, 'index'])->name('admin.viewroom');
    Route::get('/room/add', [RoomController::class, 'show'])->name('room_add');
    Route::post('/room/store', [RoomController::class, 'store'])->name('room_store');
    // Route::delete('/room/{room_id}', [RoomController::class, 'destroy'])->name('room_destroy');
    Route::delete('room/{room_id}', [RoomController::class, 'destroy'])->name('room.destroy');
    // Admin - Post
    Route::get('/post', [PostsController::class, 'viewPost'])->name('admin.viewpost');
    Route::get('/post/add', [PostsController::class, 'postAdd'])->name('post_add');

    // Admin - User
    Route::get('/user', [UsersController::class, 'viewUser'])->name('admin.viewuser');
    Route::get('/user/add', [UsersController::class, 'userAdd'])->name('user_add');
});
