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
use App\Http\Controllers\CoinApiController;
use App\Http\Controllers\CashApiController;
use App\Http\Controllers\CryptocurrencyapiApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserApiController;

Route::post('/signup',                          [AuthController::class, 'signup']);
Route::post('/login',                           [AuthController::class, 'authenticate']);
Route::post('/forgot/password',                 [AuthController::class, 'forgotPassword']);
Route::post('/validate/otp',                    [AuthController::class, 'validateOTP']);
Route::post('/resend/otp',                      [AuthController::class, 'resendOTP']);
Route::post('/reset/password',                  [AuthController::class, 'resetPassword']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::prefix('/coin')->group(function() {
        Route::get('/prices',                               [CoinApiController::class, 'getPrices']);
        Route::get('/portfolio',                            [CoinApiController::class, 'getPortfolio']);
        Route::get('/balances',                             [CoinApiController::class, 'getWalletBalances']);
        Route::get('/coin',                                 [CoinApiController::class, 'getCoin']);
        Route::get('/coin/chart',                           [CoinApiController::class, 'getCoinMarketChart']);
        Route::post('/charge',                              [CoinApiController::class, 'generateAddress']);
        Route::post('/order',                               [CoinApiController::class, 'order']);
        Route::post('/order/cancel',                        [CoinApiController::class, 'cancelOrder']);
        Route::post('/order/rate',                          [CoinApiController::class, 'orderRate']);
        Route::post('/withdraw',                            [CoinApiController::class, 'withdraw']);
        Route::get('/withdraw/fee',                        [CoinApiController::class, 'withdrawFee']);
    });

    Route::prefix('/cash')->group(function() {
        Route::post('/charge/mobile',                           [CashApiController::class, 'mobileCharge']);
        Route::post('/charge/bank',                             [CashApiController::class, 'bankCharge']);
        Route::post('/payout/mobile',                           [CashApiController::class, 'mobilePayout']);
        Route::post('/payout/bank',                             [CashApiController::class, 'bankPayout']);
        Route::post('/pay',                                     [CashApiController::class, 'pay']);
        Route::post('/withdraw',                                [CashApiController::class, 'withdraw']);
        Route::get('/withdraw/fee',                            [CashApiController::class, 'withdrawFee']);
        Route::get('/rate',                                     [CashApiController::class, 'rate']);
        Route::get('/payout/fee',                               [CashApiController::class, 'payoutFee']);
        Route::post('/webhook',                                 [CashApiController::class, 'webhook']);
    });

    Route::get('/users',                                    [UserApiController::class, 'search']);
    Route::get('/user',                                     [UserApiController::class, 'user']);
    Route::post('/user',                                    [UserApiController::class, 'update']);
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
    Route::post('/charge/bank',                             [FlutterwaveApiController::class, 'bankCharge']);
    Route::post('/payout/mobile',                           [FlutterwaveApiController::class, 'mobilePayout']);
    Route::post('/payout/bank',                             [FlutterwaveApiController::class, 'bankPayout']);
    Route::get('/rate',                                     [FlutterwaveApiController::class, 'rate']);
    Route::get('/payout/fee',                               [FlutterwaveApiController::class, 'payoutFee']);
    Route::post('/webhook',                                 [FlutterwaveApiController::class, 'webhook']);
    Route::post('/mobilecharge/webhook/{id}',               [FlutterwaveApiController::class, 'mobileChargeWebhook']);
});

Route::prefix('/coinbase')->group(function() {
    Route::get('/accounts',                           [CoinbaseApiController::class, 'getAccounts']);
    Route::get('/prices',                           [CoinbaseApiController::class, 'getPrices']);
    Route::post('/order',                           [CoinbaseApiController::class, 'order']);
    Route::get('/order',                           [CoinbaseApiController::class, 'order']);
    Route::get('/charge',                           [CoinbaseApiController::class, 'charge']);
    Route::post('/swap',                           [CoinbaseApiController::class, 'convert']);
    Route::post('/profile',                           [CoinbaseApiController::class, 'createProfile']);
    Route::get('/profile',                           [CoinbaseApiController::class, 'getProfile']);
    Route::get('/currencies',                           [CoinbaseApiController::class, 'getCurrencies']);
});

Route::post('/cryptocurrencyapi/ipn',				            [CryptocurrencyapiApiController::class, 'check_ipn']);
