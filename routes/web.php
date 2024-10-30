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
use App\Http\Controllers\ContactController;



use Illuminate\Support\Facades\Route;
// Route người dùng 
Route::get('/', function () {
    return view('pages/home');
})->name('home');
// Route::middleware(['auth'])->group(function () {
//     Route::get('/', function () {
//         return view('pages/home');
//     })->name('home');
// });


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

Route::get('/search_layout', function () {
    return view('partials/search_layout');
});


Route::get('/hotel_detail', function () {
    return view('pages/hotel_detail');
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
    Route::delete('room/{room_id}', [RoomController::class, 'destroy'])->name('room.destroy');
    Route::get('/room/edit/{id}', [RoomController::class, 'edit'])->name('room.edit');
    Route::put('/rooms/update/{room_id}', [RoomController::class, 'update'])->name('room_update');
    Route::post('/room/search', [RoomController::class, 'keywordSearch'])->name('room.search');
    Route::delete('/room/delete-image/{id}', [RoomController::class, 'deleteImage'])->name('room.delete-image');
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
    // Admin - Hotel
    Route::get('/hotel', action: [HotelController::class, 'viewHotel'])->name('admin.viewhotel');
    Route::post('/hotel/store', [HotelController::class, 'store'])->name('admin.hotel.store');
    Route::get('/hotel/edit/{hotel_id}', [HotelController::class, 'editHotel'])->name('hotel.edit');
    Route::put('/hotel/update/{hotel_id}', [HotelController::class, 'update'])->name('hotel.update');
    Route::delete('/hotel/{hotel_id}', [HotelController::class, 'destroy'])->name('hotel.destroy');
});

// Admin-Post Detail
Route::get('/posts/{post_id}/detail', action: [PostsController::class, 'getPostDetail'])->name('post.detail');
Route::get('/search', [PostsController::class, 'search'])->name('search');
Route::delete('/posts/{post_id}/delete', [PostsController::class, 'deletePost'])->name('post.delete');
Route::get('/posts/{post_id}/edit', action: [PostsController::class, 'editPost'])->name('post.edit');
Route::put('/admin/posts/{id}', [PostsController::class, 'update'])->name('admin.post.update');
// User-Blog
Route::get('/search1', action: [PostsController::class, 'searchViewBlog'])->name('searchBlog');
Route::get('/blog', [PostsController::class, 'getViewBlog'])->name('blog');
Route::get('/blog/{url_seo}', [PostsController::class, 'getBlogDetail'])->name('blog.detail');

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

// Admin - Hotel Detail
Route::get('/hotels/{hotel_id}/detail', [HotelController::class, 'getHotelDetail'])->name('hotel.detail');
Route::get('admin/hotels/search', [HotelController::class, 'searchAdminHotel'])->name('admin.hotels.search');
Route::delete('/hotels/{hotel_id}/delete', [HotelController::class, 'deleteHotel'])->name('hotel.delete');
Route::get('/hotels/add', [HotelController::class, 'create'])->name('hotel_add');

// Admin- VOUCHER
Route::get('/admin/voucher', [PromotionsController::class, 'viewVoucher'])->name('admin.viewvoucher');
Route::get('/voucher/{promotion_id}/detail', action: [PromotionsController::class, 'getVoucherDetail'])->name('voucher.detail');
Route::get('/vouchers/search', [PromotionsController::class, 'searchVoucher'])->name('search.vouchers');
Route::delete('/voucher/{promotion_id}', action: [PromotionsController::class, 'destroy'])->name('voucher.delete');
Route::get('/admin/voucher/add', [PromotionsController::class, 'voucherAdd'])->name('voucher_add');
Route::post('/admin/voucher/store', [PromotionsController::class, 'storeVoucher'])->name('admin.promotion.store');
Route::get('/admin/voucher/edit/{promotion_id}', [PromotionsController::class, 'editVoucher'])->name('voucher.edit');
Route::put('/admin/voucher/update/{id}', [PromotionsController::class, 'updateVoucher'])->name('admin.voucher.update');
// Search
// Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/hotels', [HotelController::class, 'viewSearchHotel'])->name('hotels.index');
Route::get('hotels/search', [HotelController::class, 'search'])->name('hotels.search');
// Cities
// Route::get('/partials/search', [CitiesController::class, 'index'])->name('home');

Route::get('/error', function () {
    return view('error');
})->name('error');

// Pay
Route::get('/payment', [PaymentsController::class, 'viewPay'])->name('pages.pay');

// Xem danh sách khách sạn
Route::get('/admin/hotel', [HotelController::class, 'viewHotel'])->name('admin.viewhotel');

// User Home
Route::get('/', [HotelController::class, 'index']);

Route::get('/contact', action: [ContactController::class, 'contact'])->name('contact');
Route::post('/contact', action: [ContactController::class, 'sendMail']);