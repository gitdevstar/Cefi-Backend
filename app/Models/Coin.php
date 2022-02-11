<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coin extends Model
{
    use HasFactory;

    protected $fillable = ['symbol', 'name', 'coingecko_id',
            'image', 'current_price', 'price_change_24h', 'price_change_percentage_24h', 'market_cap', 'high_24h', 'low_24h'];

    protected $hidden = ['created_at'];

    public function coinwallet($userId)
    {
        return $this->hasOne('App\Models\CoinWallet', 'coin', 'symbol')->where('user_id', $userId)->first();
    }
}
