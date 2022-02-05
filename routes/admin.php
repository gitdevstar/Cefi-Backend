<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin','middleware' => 'admin'], function () {

    Route::get('/',                                     [AdminController::class, 'dashboard'])->name('index');
    Route::get('/dashboard',                            [AdminController::class, 'dashboard'])->name('dashboard');

    Route::resource('user',                             UserController::class);

    Route::get('settings',                              [AdminController::class, 'settings'])->name('settings');
    Route::post('settings/store',                       [AdminController::class, 'settings_store'])->name('settings.store');

    Route::get('profile', 								[AdminController::class, 'profile'])->name('profile');
    Route::post('profile', 								[AdminController::class, 'profile_update'])->name('profile.update');

    Route::get('password', 								[AdminController::class, 'password'])->name('password');
    Route::post('password', 							[AdminController::class, 'password_update'])->name('password.update');

    Route::get('payment', 								[AdminController::class, 'payment'])->name('payment');
    Route::get('payment/request_payment_list', 			[AdminController::class, 'request_payment'])->name('request.payment');// provider request payout
    Route::get('payment/{id}/updaterequestmoney', 		[AdminController::class, 'update_request_money'])->name('provider.updaterequestmoney');
    Route::get('payment/user_request_payment_list', 	[AdminController::class, 'request_user_payment'])->name('request.user_payment');// provider request payout
    Route::get('payment/{id}/user_updaterequestmoney', 		[AdminController::class, 'update_request_user_money'])->name('user.updaterequestmoney');
});
