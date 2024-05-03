<?php

use App\Http\Controllers\BookingScheduleController;
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

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HotelbookingsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\PspUploadController;
use App\Http\Controllers\PublicHotelRoomController;
use App\Livewire\PublicHotelRoom;

Route::get('/', function () {
	return redirect('sign-in');
})->middleware('guest');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::get('sign-up', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('sign-up', [RegisterController::class, 'store'])->middleware('guest');
Route::get('sign-in', [SessionsController::class, 'create'])->middleware('guest')->name('login');
Route::post('sign-in', [SessionsController::class, 'store'])->middleware('guest');
Route::post('verify', [SessionsController::class, 'show'])->middleware('guest');
Route::post('reset-password', [SessionsController::class, 'update'])->middleware('guest')->name('password.update');
Route::get('verify', function () {
	return view('sessions.password.verify');
})->middleware('guest')->name('verify');
Route::get('/reset-password/{token}', function ($token) {
	return view('sessions.password.reset', ['token' => $token]);
})->middleware('guest')->name('password.reset');


// Route for displaying public hotel room information
Route::get('/rooms/{roomID}', PublicHotelRoom::class)->name('rooms.show');



Route::post('sign-out', [SessionsController::class, 'destroy'])->middleware('auth')->name('logout');
Route::get('profile', [ProfileController::class, 'create'])->middleware('auth')->name('profile');
Route::post('user-profile', [ProfileController::class, 'update'])->middleware('auth');


Route::group(['middleware' => 'auth'], function () {
	Route::get('billing', function () {
		return view('pages.billing');
	})->name('billing');
	Route::get('dduploader', function () {
		return view('dduploader.uploader');
	})->name('dduploader');
	Route::get('tables', function () {
		return view('pages.tables');
	})->name('tables');
	Route::get('rtl', function () {
		return view('pages.rtl');
	})->name('rtl');
	Route::get('virtual-reality', function () {
		return view('pages.virtual-reality');
	})->name('virtual-reality');
	Route::get('notifications', function () {
		return view('pages.notifications');
	})->name('notifications');
	Route::get('static-sign-in', function () {
		return view('pages.static-sign-in');
	})->name('static-sign-in');
	Route::get('static-sign-up', function () {
		return view('pages.static-sign-up');
	})->name('static-sign-up');
	Route::get('user-management', function () {
		return view('pages.laravel-examples.user-management');
	})->name('user-management');
	Route::get('user-profile', function () {
		return view('pages.laravel-examples.user-profile');
	})->name('user-profile');
	Route::get('hotel.unassignedbookings', [HotelbookingsController::class, 'index'])->name('hotel-unassignedbookings');
	Route::patch('hotel.unassignedbookings/assign/{id}', [HotelbookingsController::class, 'assign'])->name('hotel-unassignedbookings.assign');
	Route::post('hotel.unassignedbookings/upload-service-photo', [HotelbookingsController::class, 'uploadServicePhoto'])->name('hotel-unassignedbookings.upload-service-photo');
	Route::patch('hotel.assignedbookings/update/{id}', [HotelbookingsController::class, 'update'])->name('hotel-assignedbookings.update');
	Route::patch('hotel.assignedbookings/upload-dog-photo/{id}', [HotelbookingsController::class, 'uploadDogPhoto'])->name('hotel-assignedbookings.upload-dog-photo');
	Route::delete('hotel.assignedbookings/delete/{id}', [HotelbookingsController::class, 'delete'])->name('hotel-assignedbookings.delete');
	Route::get('hotel.assignedbookings/delete/{id}', [HotelbookingsController::class, 'delete'])->name('hotel-assignedbookings.delete');
	Route::get('hotel/booking-schedule', [BookingScheduleController::class, 'index'])->name('hotel-booking-schedule');

	Route::get('/upload', [PspUploadController::class, 'showForm'])->name('psp.upload.form');
});
