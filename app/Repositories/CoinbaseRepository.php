<?php

namespace App\Repositories;

use Lin\Coinbase\Coinbase;

class CoinbaseRepository extends CoinSummaryRepository
{

    /**
     * Configure the api
     **/
    public function api()
    {
        return Coinbase::class;
    }

    public function generateAddress(){}
    public function order(){}
    public function swap(){}
    public function withdraw(){}
}
