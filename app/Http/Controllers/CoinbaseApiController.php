<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

use Lin\Coinbase\Coinbase;
use Lin\Coinbase\CoinbasePro;

class CoinbaseApiController extends Controller
{
    //
    private $coinbase = null;

    public function __construct()
    {
        $apiKey = Config::get('coinbase.api_key');
        $secretKey = Config::get('coinbase.secret_key');
        $api = Config::get('coinbase.api');

        if($api == 'pro')
            $coinbase=new CoinbasePro($apiKey, $secretKey);
        else
            $coinbase=new Coinbase($apiKey, $secretKey);
    }

    public function order(Request $request)
    {
        $this->validate($request, [
            'type' => 'required|in:limit,market',
            'side' => 'required|in:sell,buy',
            'pair' => 'required', //'BTC-USD'
            'price' => 'required_if:type,market',
            'amount' => 'required'
        ]);

        $type = $request->type;
        $side = $request->side;
        $pair = $request->pair;
        $price = $request->price;
        $amount = $request->amount;

        try {
            $result=$this->coinbase->order()->post([
                'type'=>$type,
                'side'=>$side,
                'product_id'=>$pair,
                'price'=>$price,
                'size'=>$amount
            ]);
            return response()->json(['result' => $result]);
        }catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
