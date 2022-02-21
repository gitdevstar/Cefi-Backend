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
        'status', // 0[unpaid],1[paid],2[rejected]
        'txn_id'
    ];

    protected $hidden = ['created_at', 'txn_id'];
}
