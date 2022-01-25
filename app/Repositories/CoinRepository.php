<?php

namespace App\Repositories;

use App\Models\Coin;

class CoinRepository
{

    public function getIds()
    {
        $coins = Coin::all();
        $ids = array_column(json_decode($coins), 'coingecko_id');
        return implode(',', $ids);
    }
}
