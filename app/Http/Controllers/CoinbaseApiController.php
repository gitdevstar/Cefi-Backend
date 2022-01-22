<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

use Lin\Coinbase\Coinbase;
use Lin\Coinbase\CoinbasePro;

class CoinbaseApiController extends Controller
{
    //
    private $coinbasePro = null;
    private $coinbase = null;

    public function __construct()
    {
        $api = Config::get('api.coinbase_platform');

        if($api == 'coinbase_pro') {
            $apiKey = Config::get('api.coinbase_pro.api_key');
            $secretKey = Config::get('api.coinbase_pro.secret_key');
            $passphrase = Config::get('api.coinbase_pro.passphrase');
            $this->coinbasePro=new CoinbasePro($apiKey, $secretKey, $passphrase);
        }
        else {

        }
        $apiKey = Config::get('api.coinbase.api_key');
        $secretKey = Config::get('api.coinbase.secret_key');
        $this->coinbase=new Coinbase($apiKey, $secretKey);
    }

    public function getAccounts(Request $request)
    {
        $type = $request->type ?? "pro";
        try {
            if($type == "pro")
                $accounts = $this->coinbasePro->account()->getList();
            else {
                $data["limit"] = 300;
                $accounts = $this->coinbase->privates()->getAccounts($data);
            }

            return response()->json(['accounts' => $accounts]);

        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public function getPrices()
    {
        try {
            $result = $this->coinbasePro->oracle()->get();

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
        $type = $request->type ?? "pro";

        try {
            $data['account_id'] = $currency;
            if($type == "pro")
                $address = $this->coinbasePro->coinbase()->generateCryptoAddress($data);
            else
                $address = $this->coinbase->privates()->postAccountAddresses($data);

            return response()->json(['address' => $address]);

        } catch (\Throwable $th) {
            return response()->json(['error' => json_decode($th->getMessage(), true)]);
        }
    }

    public function convert(Request $request)
    {
        $this->validate($request, [
            'from' => 'required',
            'to' => 'required',
            'amount' => 'required',
        ]);

        $from = $request->from;
        $to = $request->to;
        $amount = $request->amount;

        try {
            $data = array(
                'from' => $from,
                'to' => $to,
                'amount' => $amount,
            );

            $result = $this->coinbasePro->conversion()->post($data);

            return response()->json(['result' => $result]);

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
        $price = $request->price;
        $amount = $request->amount;

        try {
            $result=$this->coinbasePro->order()->post([
                'type'=>$type,
                'side'=>$side,
                'product_id'=>$pair,
                'price'=>$price,
                'size'=>$amount
            ]);
            return response()->json(['result' => $result]);
        }catch (\Exception $e){
            return response()->json(['error' => json_decode($e->getMessage(), true)], 500);
        }
    }

    public function createProfile(Request $request)
    {
        try {
            $data = array(
                'name' => $request->name ?? 'tst34',
            );

            $result = $this->coinbasePro->profiles()->post($data);

            return response()->json(['result' => $result]);

        } catch (\Throwable $th) {
            return response()->json(['error' => json_decode($th->getMessage(), true)]);
        }
    }

    public function getProfile(Request $request)
    {
        try {
            if($request->has('profile_id')) {

                $data = array(
                    'profile_id' => $request->profile_id,
                );

                $result = $this->coinbasePro->profiles()->get($data);
            } else {
                $result = $this->coinbasePro->profiles()->getList();

            }

            return response()->json(['result' => $result]);

        } catch (\Throwable $th) {
            return response()->json(['error' => json_decode($th->getMessage(), true)]);
        }
    }

    public function getCurrencies(Request $request)
    {
        $type = $request->type ?? "pro";
        try {
            if($type == "pro")
                $accounts = $this->coinbasePro->system()->getCurrencies();
            else
                $accounts = $this->coinbase->publics()->getCurrencies();

            return response()->json(['accounts' => $accounts]);

        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }
}
