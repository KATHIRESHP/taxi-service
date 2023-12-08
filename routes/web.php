<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserAuthController as UserAuthController;
use App\Http\Controllers\Driver\DriverAuthController;
use App\Http\Controllers\RideController;
use App\Http\Controllers\Driver\DriverController;
use \App\Http\Controllers\User\UserController;
use \App\Http\Controllers\RatingController;
use App\Http\Controllers\Driver\DriverRideController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;

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
    return view('landpage');
})->name('landpage');

//Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('user')->name('user.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::view('/login', 'user.auth.login')->name('login');
        Route::view('/register', 'user.auth.register')->name('register');
        Route::post('/store', [UserAuthController::class, 'register'])->name('store');
        Route::post('/check', [UserAuthController::class, 'check'])->name('check');
    });
    Route::middleware(['auth', 'preventBackHistory'])->group(function () {
        Route::get('/home', [UserController::class, 'show'])->name('home');
        Route::put('/home/{user}', [UserController::class, 'update'])->name('update');
        Route::prefix('/ride')->name('ride.')->group(function () {
            Route::get('/', [UserController::class, 'userRides'])->name('rides');
            Route::get('/create', [RideController::class, 'create'])->name('create');
            Route::post('/store', [RideController::class, 'store'])->name('store');
            Route::get('/show/{id}', [RideController::class, 'show'])->name('show');
            Route::put('/complete/{ride}', [RideController::class, 'complete'])->name('complete');
            Route::put('/cancel/{ride}', [RideController::class, 'cancel'])->name('cancel');
            Route::put('/pay/{ride}', [RideController::class, 'pay'])->name('pay');
            Route::put('/rate/{id}', [RatingController::class, 'update'])->name('rate');
            Route::delete('/{ride}', [RideController::class, 'destroy'])->name('delete');
        });
        Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');
    });
});

Route::prefix('driver')->name('driver.')->group(function () {
    Route::middleware('guest:driver')->group(function () {
        Route::view('/login', 'driver.auth.login')->name('login');
        Route::view('/register', 'driver.auth.register')->name('register');
        Route::post('/store', [DriverAuthController::class, 'register'])->name('store');
        Route::post('/check', [DriverAuthController::class, 'check'])->name('check');

    });
    Route::middleware(['auth:driver', 'preventBackHistory'])->group(function () {
        Route::get('/home', [DriverController::class, "show"])->name('home');
        Route::put('/home/{driver}', [DriverController::class, 'update'])->name('update');
        Route::post('/logout', [DriverAuthController::class, 'logout'])->name('logout');
        Route::post('/updatelocation', [DriverController::class, 'updateLocation'])->name('updatelocation');
        Route::put('/checkin', [DriverController::class, 'checkin'])->name('checkin');
        Route::put('/checkout', [DriverController::class, 'checkout'])->name('checkout');
        Route::prefix('/ride')->name('ride.')->group(function () {
            Route::get('/requests', [DriverRideController::class, 'rideRequests'])->name('requests');
            Route::get('/currentride', [DriverRideController::class, 'currentRide'])->name('currentride');
            Route::get('/{ride}', [DriverRideController::class, 'showRide'])->name('show');
            Route::put('/pickup/{ride}', [DriverRideController::class, 'pickup'])->name('pickup');
            Route::put('/complete/{ride}', [DriverRideController::class, 'complete'])->name('complete');
            Route::put('/accept/{ride}', [DriverRideController::class, 'acceptRide'])->name('accept');
            Route::put('/reject/{ride}', [DriverRideController::class, 'rejectRide'])->name('reject');
        });
    });
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'login'])->name('login');
        Route::post('/check', [AdminAuthController::class, 'check'])->name('check');
    });
    Route::middleware(['auth:admin', 'preventBackHistory'])->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/', [AdminController::class, 'home'])->name('home');
        Route::get('/previous-day-rides', [AdminController::class, 'previousDayRide'])->name('previousDayRide');
        Route::name('ride.')->prefix('ride')->group(function () {
            Route::get('/{id}', [AdminController::class, 'showRide'])->name('show');
            Route::delete('/{ride}', [AdminController::class, 'destroyRide'])->name('destroy');
        });
        Route::prefix('/driver')->name('driver.')->group(function () {
            Route::get('/index', [AdminController::class, 'driverIndex'])->name('index');
        });
    });
});
