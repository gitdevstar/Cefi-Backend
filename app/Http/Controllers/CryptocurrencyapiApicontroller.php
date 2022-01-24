<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Exception;

use App\Models\User;
use App\Models\CoinDeposit;
use App\Models\CoinWallet;
use App\Models\CoinCallbackAddress;
use App\Repositories\UserRepository;

class CryptocurrencyapiApiController extends Controller
{
    protected static $apiKey;
    protected static $base_url = "https://cryptocurrencyapi.net/api";
    protected static $version = "";
    protected static $url;
    protected static $ipn;

    /** @var  UserRepository */
    private $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        self::$apiKey = Config::get('api.cryptocurrencyapi.api_key');
        self::$url = self::$base_url . self::$version;
        self::$ipn = Config::get('api.cryptocurrencyapi.ipn');

        $this->userRepo = $userRepo;
    }

    /*
        params: $token
        return: address, token
    */
    public function generate_address(Request $request)
    {
        $token = $request->token;
        try {
            $result = json_decode(file_get_contents(self::$url . '/.give?key=' . self::$apiKey . '&currency='.$token.'&statusURL='.self::$ipn), true);

            if(!isset($result['result'])) {
                throw new Exception($result['error']);
            }

            $address = $result['result'];

            return $address;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    /*
    return result
    */
    public function get_balance($token, $address)
    {
        try {
            $result = json_decode(file_get_contents(self::$url . '/.balance?key=' . self::$apiKey . '&currency='.$token.'&from='.$address));
            return $result->result;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    /*
    return result
    */
    public function withdraw(Request $request)
    {
        $token = $request->get('token');
		$address = $request->get('address');
		$amount = $request->get('amount');
        try {
            $result = json_decode(file_get_contents(self::$url . '/.send?key=' . self::$apiKey . '&currency='.$token.'&address='.$address.'&amount='.$amount));

            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function check_ipn()
    {
        if (!$_POST) {
            $_POST = @json_decode(file_get_contents('php://input'), true);
            Log::info('cryptocurrencyapi ipn: '.json_encode($_POST));
        }
        if (!$_POST['cryptocurrencyapi.net'])
            return;
        // $sign2 = sha1(implode(':', array(
        //     $_POST['currency'],
        //     $_POST['type'], //(in-payment / track-tracking / out-sending)
        //     $_POST['date'],
        //     $_POST['address'],
        //     $_POST['amount'],
        //     $_POST['txid'],
        //     $_POST['confirmations'],
        //     $_POST['tag'],
        //     self::$apiKey // API access key
        // )));

        // if ($sign2 !== $_POST['sign2'])
        //     die('Sign wrong'); // this answer will be visible in the dashboard

        if( $_POST['type'] == 'in') {

            $this->userRepo->updateCoinBalance($_POST);
        } else {
            // $userId = CoinWithdraw::where('address', $_POST['to'])->first()->user_id;
            // CoinWithdraw::where('user_id', $userId)->
            //         where('address', $_POST['to'])->update(['auto_confirm' => $_POST['confirmations'], 'txn_id' => $_POST['txid']]);

            // if($_POST['confirmations'] == 12) {

            //     $user = User::find($userId);
            //     $coin = Coin::where('coin_symbol', $_POST['token'])->first();
            //     $walletBalance = $user->coinwallet($coin->id) ? $user->coinwallet($coin->id)->balance : 0;
            //     CoinWithdraw::where('user_id', $userId)->
            //         where('address', $_POST['to'])->update(['auto_confirm' => $_POST['confirmations'], 'status_text' => 'Confirmed']);
            // }
        }
    }

}
