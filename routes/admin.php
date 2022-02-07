<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'admin'], function () {

    Route::get('/',                                     [AdminController::class, 'dashboard'])->name('index');
    Route::get('/dashboard',                            [AdminController::class, 'dashboard'])->name('dashboard');

    Route::resource('/user',                             UserController::class);

    Route::get('/settings',                              [AdminController::class, 'settings'])->name('settings');
    Route::post('/settings/store',                       [AdminController::class, 'settings_store'])->name('settings.store');

    Route::get('/profile', 								[AdminController::class, 'profile'])->name('profile');
    Route::post('/profile', 								[AdminController::class, 'profile_update'])->name('profile.update');

    Route::get('/password', 								[AdminController::class, 'password'])->name('password');
    Route::post('/password', 							[AdminController::class, 'password_update'])->name('password.update');

    Route::get('/withdraw', 								[AdminController::class, 'withdrawList'])->name('withdraw');
    Route::get('/withdraw/{id}/approve', 			    [AdminController::class, 'approveWithdraw'])->name('withdraw.approve');// provider request payout
    Route::get('/withdraw/{id}/unapprove', 		        [AdminController::class, 'unApproveWithdraw'])->name('withdraw.unapprove');
});
