<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoinWallet extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'coin', 'balance'];

    protected $hidden = ['created_at', 'updated_at'];
}