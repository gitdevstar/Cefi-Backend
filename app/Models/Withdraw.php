<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'to',
        'amount',
        'kind', // [cash, coin],
        'status',
        'txn_id'
    ];

    protected $hidden = ['updated_at'];
}
