<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

use App\Libs\Coingecko\Coingecko;
use App\Libs\CryptocurrencyApi\CryptocurrencyapiApi;
use App\Models\Coin;
use App\Models\CoinCallbackAddress;
use App\Models\Order;
use App\Models\Withdraw;
use App\Repositories\CoinRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Log;
use Lin\Coinbase\CoinbasePro;

class CoinApiController extends Controller
{
    /** @var  UserRepository */
    private $userRepo;
    /** @var  CoinRepository */
    private $coinRepo;


    public function __construct(CoinRepository $coinRepo, UserRepository $userRepo)
    {
        $this->coinRepo = $coinRepo;
        $this->userRepo = $userRepo;
    }

    public function getPrices()
    {
        try {
            $result = $this->coinRepo->all();

            return response()->json(['result' => $result]);

        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function updatePrices()
    {
        $this->coinRepo->updatePrices();
    }

    public function getPortfolio()
    {
        try {
            $portfolio = $this->userRepo->getPortfolio();
            return response()->json(['result' => $portfolio]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }

    }

    public function getWalletBalances()
    {
        try {
            $user = Auth::user();
            $wallets = $user->coinwallets;
            return response()->json(['result' => $wallets]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }

    }

    public function getCoin(Request $request)
    {
        $this->validate($request, [
            'coin_id' => 'required',
        ]);

        try {
            $id = $request->coin_id;
            $coin = Coin::find($id);
            $coinId = $coin->coingecko_id;
            $result = Coingecko::getCoinsMarkets($coinId);
            $wallet = $coin->coinwallet(Auth::id());
            $data = $result[0];
            $data['balance'] = $wallet ? $wallet->balance : 0;

            return response()->json(['result' => $data]);

        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public function getCoinMarketChart(Request $request)
    {
        $this->validate($request, [
            'coin_id' => 'required',
            'days' => 'required'
        ]);

        try {
            $id = $request->coin_id;
            $coinId = Coin::find($id)->coingecko_id;
            $data['days'] = $request->days;
            $result = Coingecko::getCoinMarketChart($coinId, $data);

            return response()->json(['result' => $result]);

        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public function charge(Request $request)
    {
        $this->validate($request, [
            'currency' => 'required|in:BTC,LTC,DASH,DOGE,BCH'
        ]);

        $currency = $request->currency;

        try {
            $address = CryptocurrencyapiApi::generateAddress($currency);

            CoinCallbackAddress::create([
                'user_id' => Auth::user()->id,
                'address' => $address,
                'coin' => $currency
            ]);

            return response()->json(['address' => $address]);

        } catch (\Throwable $th) {
            return response()->json(['error' => json_decode($th->getMessage(), true)]);
        }
    }

    public function orderRate(Request $request)
    {
        $this->validate($request, [
            'type' => 'in:limit,market',
            'side' => 'required|in:sell,buy',
            'sell_coin_id' => 'required',
            'buy_coin_id' => 'required'
        ]);

        $type = $request->type ?? 'market';
        $side = $request->side;

        $sellid = $request->sell_coin_id;
        $buyid = $request->buy_coin_id;
        $sellcoinId = Coin::find($sellid)->coingecko_id;
        $buycoinId = Coin::find($buyid)->coingecko_id;

        try {
            $result = Coingecko::getCoinsMarkets($sellcoinId);
            $sellCoinPrice = $result[0]->price;
            $result = Coingecko::getCoinsMarkets($buycoinId);
            $buyCoinPrice = $result[0]->price;
            $fee = 0.4;
            return response()->json(['sellCoinPrice' => $sellCoinPrice, 'buyCoinPrice' => $buyCoinPrice, 'fee' => $fee]);
        } catch (\Throwable $th) {
            return response()->json(['error' => json_decode($th->getMessage(), true)], 500);
        }

    }

    public function order(Request $request)
    {
        $this->validate($request, [
            'type' => 'in:limit,market',
            'side' => 'required|in:sell,buy',
            'pair' => 'required', //'BTC-USD'
            'price' => 'required_if:type,limit',
            'amount' => 'required'
        ]);

        $type = $request->type ?? 'market';
        $side = $request->side;
        $pair = $request->pair;
        $price = $request->price ?? 0;
        $amount = $request->amount;

        try {
            $coinbasePro = new CoinbasePro(
                Config::get('api.coinbase_pro.api_key'),
                Config::get('api.coinbase_pro.secret_key'),
                Config::get('api.coinbase_pro.passphrase')
            );
            $result=$coinbasePro->order()->post([
                'type'=>$type,
                'side'=>$side,
                'product_id'=>$pair,
                'price'=>$price,
                'size'=>$amount
            ]);

            Order::create([
                'user_id' => Auth::user()->id,
                'type' => $type,
                'side' => $side,
                'pair' => $pair,
                'price' => $price,
                'amount' => $amount,
                'txn_id' => ''
            ]);

            return response()->json(['result' => $result]);
        }catch (\Exception $e){
            return response()->json(['error' => json_decode($e->getMessage(), true)], 500);
        }
    }

    public function withdraw(Request $request)
    {
        $this->validate($request, [
            'to' => 'required',
            'amount' => 'required'
        ]);

        $user = Auth::user();
        $amount = $request->amount;
        if($amount == 0)
            return response()->json(['status' => false, 'error' => 'Invalidate amount.'], 500);
        if($user->balance < $amount)
            return response()->json(['status' => false, 'error' => 'Insufficient amount.'], 500);

        Withdraw::create([
            'user_id' => Auth::user()->id,
            'to' => $request->to,
            'kind' => $request->currency ?? 'USDC',
            'amount' => $amount,
        ]);

        return response()->json(['status' => true, 'message' => 'Sent your withdraw request. It will take 2 or 3 business days.']);
    }

}
