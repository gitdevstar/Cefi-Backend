<?php

namespace App\Repositories;

use App\Libs\CryptocurrencyapiApi;

class CryptocurrencyApiRepository extends CoinSummaryRepository
{

    /**
     * Configure the api
     **/
    public function api()
    {
        return CryptocurrencyapiApi::class;
    }

    public function generateAddress(){}
    public function order(){}
    public function swap(){}
    public function withdraw(){}
}
