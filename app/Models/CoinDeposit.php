<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoinDeposit extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'symbol', 'address', 'confirms', 'amount', 'txn_id'];

    protected $hidden = ['created_at', 'updated_at'];
}
