<?php

namespace App\Repositories;

use Lin\Coinbase\CoinbasePro;

class CoinbaseProRepository extends CoinSummaryRepository
{

    /**
     * Configure the api
     **/
    public function api()
    {
        return CoinbasePro::class;
    }

    public function generateAddress(){}
    public function order(){}
    public function swap(){}
    public function withdraw(){}
}
