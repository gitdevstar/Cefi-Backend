<?php

namespace App\Libs\CryptocurrencyApi;

use Illuminate\Support\Facades\Config;

class CryptocurrencyapiApi
{
    protected static $apiKey;
    protected static $base_url = "https://cryptocurrencyapi.net/api";
    protected static $version = "";
    protected static $url;
    protected static $ipn;

    public function __construct()
    {

    }

    /*
        params: $token
        return: address, token
    */
    public static function generateAddress($token)
    {
        try {
            self::$apiKey = Config::get('api.cryptocurrencyapi.api_key');
            self::$url = self::$base_url . self::$version;
            self::$ipn = Config::get('api.cryptocurrencyapi.ipn');
            $result = json_decode(file_get_contents(self::$url . '/.give?key=' . self::$apiKey . '&currency='.$token.'&statusURL='.self::$ipn), true);

            if(!isset($result['result'])) {
                throw new \Throwable($result['error']);
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
    public function getBalance($token, $address)
    {
        try {
            self::$apiKey = Config::get('api.cryptocurrencyapi.api_key');
            $result = json_decode(file_get_contents(self::$url . '/.balance?key=' . self::$apiKey . '&currency='.$token.'&from='.$address));
            return $result->result;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    /*
    return result
    */
    public function withdraw($token, $address, $amount)
    {
        try {
            self::$apiKey = Config::get('api.cryptocurrencyapi.api_key');
            $result = json_decode(file_get_contents(self::$url . '/.send?key=' . self::$apiKey . '&currency='.$token.'&address='.$address.'&amount='.$amount));

            return $result;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
