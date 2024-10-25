<?php
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\CitiesController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PromotionsController;
use App\Http\Controllers\PaymentsController;


use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages/home');
})->name('welcome');
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/register', function () {
    return view('auth.register');
});
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/search_result', function () {
    return view('search_result');
});

Route::get('/header', function () {
    return view('partials/header');
});

// Route::get('/home', function () {
//     return view('pages/home');
// });

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
Route::get('/posts/{post_id}/edit', action: [PostsController::class, 'editPost'])->name('post.edit');
Route::put('/admin/posts/{id}', [PostsController::class, 'update'])->name('admin.post.update');

// Admin-Booking Detail
Route::get('/bookings/{booking_id}/detail', action: [BookingController::class, 'getBookingDetail'])->name('booking.detail');
Route::delete('/bookings/{booking_id}/delete', [BookingController::class, 'deleteBooking'])->name('booking.delete');
Route::get('/bookings/{booking_id}/edit', [BookingController::class, 'editBooking'])->name('booking.edit');
Route::put('/admin/bookings/{id}', [BookingController::class, 'update'])->name('admin.booking.update');
Route::get('/admin/booking/search', [BookingController::class, 'search'])->name('admin.booking.search');

// Admin-User Detail
Route::get('/users/{user_id}/detail', action: [UsersController::class, 'getUserDetail'])->name('user.detail');
Route::get('/users/search', [UsersController::class, 'search'])->name('user.search');
Route::delete('/users/{user_id}/delete', [UsersController::class, 'deleteUser'])->name('user.delete');
Route::get('/users/{user_id}/edit', [UsersController::class, 'editUser'])->name('user.edit');
Route::put('/admin/users/{id}', [UsersController::class, 'update'])->name('admin.user.update');
Route::get('/admin/users/search', [UsersController::class, 'search'])->name('admin.users.search');


// Admin- VOUCHER
Route::get('/admin/voucher', [PromotionsController::class, 'viewVoucher'])->name('admin.viewvoucher');
Route::get('/voucher/{promotion_id}/detail', action: [PromotionsController::class, 'getVoucherDetail'])->name('voucher.detail');
Route::get('/vouchers/search', [PromotionsController::class, 'searchVoucher'])->name('search.vouchers');
Route::delete('/voucher/{promotion_id}', action: [PromotionsController::class, 'destroy'])->name('voucher.delete');


// Search
// Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/hotels', [HotelController::class, 'index'])->name('hotels.index');
Route::get('hotels/search', [HotelController::class, 'search'])->name('hotels.search');
// Cities
// Route::get('/partials/search', [CitiesController::class, 'index'])->name('home');

Route::get('/error', function () {
    return view('error');
})->name('error');

// Pay
Route::get('/payment', [PaymentsController::class, 'viewPay'])->name('pages.pay');











<<<<<<< HEAD
=======
// Admin - User
Route::get('/admin/user', [UsersController::class, 'index'])->name('admin.viewuser');
Route::get('/admin/user/user_add', [UsersController::class, 'userAdd'])->name('user_add');
Route::post('/admin/user/user_add', [UsersController::class, 'storeUser'])->name('user.store');
Route::get('/admin/user/search', [UsersController::class, 'searchUsers'])->name('admin.searchUsers');
Route::get('/admin/user/{id}', [UsersController::class, 'show'])->name('admin.user.show');
Route::get('/admin/user/{id}/edit', [UsersController::class, 'edit'])->name('admin.user.edit');
Route::delete('/admin/user/{id}', [UsersController::class, 'destroy'])->name('admin.user.destroy');
Route::put('/admin/user/{id}', [UsersController::class, 'update'])->name('admin.user.update');
>>>>>>> UI-ThanhToan





<<<<<<< HEAD
=======







// TEST
Route::get('/hotel_detail', function () {
    return view('pages/hotel_detail');
});
>>>>>>> UI-ThanhToan
