<?php

namespace App\Libs\Coingecko;


class Coingecko
{
    protected static $base_url = "https://api.coingecko.com/api/";
    protected static $version = "v3";
    protected static $url;

    public function __construct()
    {
        self::$url = self::$base_url . self::$version;
    }

    private static function request($path, $params=[])
    {
        try {
            $params = http_build_query($params);
            $result = json_decode(file_get_contents(self::$url . $path . "?" . $params), true);
            return $result;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function getSimplePrice($data)
    {
        try {
            $result = self::request('/simple/price', $data);

            return $result;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function getCoinsMarkets($data)
    {
        try {
            $data["vs_currency"] = 'usd';
            $data["price_change_percentage"] = '24h';
            $result = self::request('/coins/markets', $data);

            return $result;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function getCoins($data=[])
    {
        try {
            $result = self::request('/coins/list', $data);

            return $result;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function getCoin($token, $data=[])
    {
        try {
            $data["localization"] = false;
            $data["community_data"] = false;
            $result = self::request('/coins/' . $token, $data);

            return $result;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public static function getCoinMarketChart($token, $data=[])
    {
        try {
            $data["vs_currency"] = 'usd';
            $result = self::request('/coins/' . $token . '/market_chart', $data);

            return $result;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
