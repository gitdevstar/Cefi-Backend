<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'photo',
        'phone_number',
        'balance',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'updated_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function coinwallet($symbol)
	{
		return $this->hasOne('App\Models\CoinWallet', 'user_id', 'id')->where('coin', $symbol)->first();
	}

    public function coinwallets()
    {
        return $this->hasMany('App\Models\CoinWallet', 'user_id', 'id');
    }

    public function portfolio()
    {
        $total = 0;
        $changeTotal = 0;
        $changePercentTotal = 0;
        $coinwallets = $this->coinwallets;
        foreach ($coinwallets as $wallet) {
            $coin = $wallet->coin();
            $total += $coin->current_price * $wallet->balance;
            $changeTotal += $coin->price_change_24h * $wallet->balance;
            if($wallet->balance > 0)
                $changePercentTotal += $coin->price_change_percentage_24h;
        }

        return array(
            'portfolio' => $total,
            'portfolio_change_24h' => $changeTotal,
            'portfolio_change_percentage_24h' => $changePercentTotal,
        );
    }
}
