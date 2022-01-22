<?php

namespace App\Repositories;

use App\Libs\Coingecko\Coingecko;

class CoingeckoRepository extends CoinSummaryRepository
{

    /**
     * Configure the api
     **/
    public function api()
    {
        return Coingecko::class;
    }

    public function getSimplePrice($token)
    {

    }

    public function generateAddress(){}
    public function order(){}
    public function swap(){}
    public function withdraw(){}
}
