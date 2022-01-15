<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use App\Http\Controllers\XanpoolApiController;
use App\Http\Controllers\TatumApiController;
use App\Http\Controllers\FlutterwaveApiController;
use App\Http\Controllers\CoinbaseApiController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/xanpool')->group(function() {
    Route::post('/signup',                          [XanpoolApiController::class, 'signup']);
    Route::post('/phone/verify',                    [XanpoolApiController::class, 'requestPhoneVerification']);
    Route::post('/phone/verify/complete',           [XanpoolApiController::class, 'completePhoneVerification']);
    Route::post('/kyc/upload',                      [XanpoolApiController::class, 'uploadKycDoc']);
    Route::post('/kyc/request',                     [XanpoolApiController::class, 'kycRequest']);
    Route::get('/cryptos',                          [XanpoolApiController::class, 'supportedCryptos']);
    Route::get('/limits',                           [XanpoolApiController::class, 'limits']);
    Route::post('/prices',                          [XanpoolApiController::class, 'prices']);
    Route::post('/estimateCost',                    [XanpoolApiController::class, 'estimateCost']);
    Route::post('/transaction/create',              [XanpoolApiController::class, 'createTransaction']);
    Route::post('/transaction/cancel',              [XanpoolApiController::class, 'cancelTransaction']);
    Route::post('/hook',                            [XanpoolApiController::class, 'hook']);
});

Route::prefix('/tatum')->group(function() {
    Route::post('generate/accounts/all',            [TatumApiController::class, 'generateAllAccounts']);
    Route::post('generate/account',                 [TatumApiController::class, 'generateAccount']);
    Route::get('account',                          [TatumApiController::class, 'getAccount']);
    Route::get('account/balance',                  [TatumApiController::class, 'getAccountBalance']);
    Route::get('customer/accounts',                [TatumApiController::class, 'getAllAccountsByCustomer']);
    Route::get('generate/address',                 [TatumApiController::class, 'generateDepositAddress']);
    Route::get('get/addresses',                      [TatumApiController::class, 'getDepositAddresses']);
    Route::get('get/eth/balance',                      [TatumApiController::class, 'getEthBalance']);
    Route::post('send',                             [TatumApiController::class, 'sendTransaction']);
});

Route::prefix('/flutter')->group(function() {
    Route::post('/charge/mobile',                           [FlutterwaveApiController::class, 'mobileCharge']);
    Route::post('/charge/bank',                           [FlutterwaveApiController::class, 'bankCharge']);
    Route::post('/payout/mobile',                          [FlutterwaveApiController::class, 'mobilePayout']);
    Route::post('/payout/bank',                          [FlutterwaveApiController::class, 'bankPayout']);
    Route::get('/rate',                          [FlutterwaveApiController::class, 'rate']);
    Route::get('/payout/fee',                          [FlutterwaveApiController::class, 'payoutFee']);
    Route::post('/webhook',                          [FlutterwaveApiController::class, 'webhook']);
});

Route::prefix('/coinbase')->group(function() {
    Route::post('/order',                           [CoinbaseApiController::class, 'order']);
    Route::get('/order',                           [CoinbaseApiController::class, 'order']);
});

