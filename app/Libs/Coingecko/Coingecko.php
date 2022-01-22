<?php

namespace App\Libs\Coingecko;


class Coingecko
{
    protected static $base_url = "https://pro-api.coingecko.com/api/";
    protected static $version = "v3";
    protected static $url;

    public function __construct()
    {
        self::$url = self::$base_url . self::$version;
    }

    private static function request($path, $params=[])
    {
        try {
            $result = json_decode(file_get_contents(self::$url . $path), true);
            return $result;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /*
        params: $token
    */
    public static function getSimplePrice($token)
    {
        try {
            $result = self::request('/simple/price');

            return $result;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
