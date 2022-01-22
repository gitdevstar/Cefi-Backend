<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

use App\Libs\Coingecko\Coingecko;
use App\Libs\CryptocurrencyapiApi\CryptocurrencyapiApi;
use App\Models\CoinCallbackAddress;
use App\Models\Order;

use App\Repositories\UserRepository;

use Lin\Coinbase\CoinbasePro;

class CoinApiController extends Controller
{
    /** @var  UserRepository */
    // private $userRepository;


    public function __construct()
    {
    }

    public function getPrices()
    {
        $tokens = [];
        try {
            $result = Coingecko::getSimplePrice($tokens);

            return response()->json(['result' => $result]);

        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public function charge(Request $request)
    {
        $this->validate($request, [
            'currency' => 'required'
        ]);

        $currency = $request->currency;

        try {
            $address = CryptocurrencyapiApi::generateAddress($currency);

            CoinCallbackAddress::create([
                'user_id' => Auth::user()->id,
                'address' => $address
            ]);

            return response()->json(['address' => $address]);

        } catch (\Throwable $th) {
            return response()->json(['error' => json_decode($th->getMessage(), true)]);
        }
    }

    public function order(Request $request)
    {
        $this->validate($request, [
            'type' => 'required|in:limit,market',
            'side' => 'required|in:sell,buy',
            'pair' => 'required', //'BTC-USD'
            'price' => 'required_if:type,limit',
            'amount' => 'required'
        ]);

        $type = $request->type;
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
            ]);

            return response()->json(['result' => $result]);
        }catch (\Exception $e){
            return response()->json(['error' => json_decode($e->getMessage(), true)], 500);
        }
    }

}
