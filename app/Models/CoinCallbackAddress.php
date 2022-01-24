<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoinCallbackAddress extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'coin', 'address'];

    protected $hidden = ['created_at', 'updated_at'];

    protected $table = 'coin_call_back_addresses';
}
