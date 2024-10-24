<?php
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\CitiesController;
use App\Http\Controllers\BookingController;
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
    Route::post('admin/post/store', action: [PostsController::class, 'store'])->name('admin.post.store');
    // Admin - Booking
    Route::get('/booking', [BookingController::class, 'viewBooking'])->name('admin.viewbooking');
    Route::post('admin/booking/store', action: [BookingController::class, 'store'])->name('admin.booking.store');
    // Admin - User
    Route::get('/user', action: [UsersController::class, 'viewUser'])->name('admin.viewuser');
    Route::get('/user/add', [UsersController::class, 'userAdd'])->name('user_add');
    Route::post('admin/user/store', action: [UsersController::class, 'store'])->name('admin.user.store');
});

// Admin-Post Detail
Route::get('/posts/{post_id}/detail', action: [PostsController::class, 'getPostDetail'])->name('post.detail');
Route::get('/search', [PostsController::class, 'search'])->name('search');
Route::delete('/posts/{post_id}/delete', [PostsController::class, 'deletePost'])->name('post.delete');
Route::get('/posts/{post_id}/edit', [PostsController::class, 'editPost'])->name('post.edit');
Route::put('/admin/posts/{id}', [PostsController::class, 'update'])->name('admin.post.update');

// Admin-Booking Detail
Route::get('/bookings/{booking_id}/detail', action: [BookingController::class, 'getBookingDetail'])->name('booking.detail');
Route::get('/searchBooking', [BookingController::class, 'searchBooking'])->name('searchBooking');
Route::delete('/bookings/{booking_id}/delete', [BookingController::class, 'deleteBooking'])->name('booking.delete');
Route::get('/bookings/{booking_id}/edit', [BookingController::class, 'editBooking'])->name('booking.edit');
Route::put('/admin/bookings/{id}', [BookingController::class, 'update'])->name('admin.booking.update');

// Admin-User Detail
Route::get('/users/{user_id}/detail', action: [UsersController::class, 'getUserDetail'])->name('user.detail');
Route::get('/searchUser', [UsersController::class, 'search'])->name('searchUser');
Route::delete('/users/{user_id}/delete', [UsersController::class, 'deleteUser'])->name('user.delete');
Route::get('/users/{user_id}/edit', [UsersController::class, 'editUser'])->name('user.edit');
Route::put('/admin/users/{id}', [UsersController::class, 'update'])->name('admin.user.update');

// Search
// Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/hotels', [HotelController::class, 'index'])->name('hotels.index');
Route::get('hotels/search', [HotelController::class, 'search'])->name('hotels.search');
// Cities
Route::get('/pages/home', [CitiesController::class, 'index']);

















