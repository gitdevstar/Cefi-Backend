<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankCharge extends Model
{
    use HasFactory;

    // protected $attributes = [
    //     'user_id',
    //     'currency',
    //     'network',
    //     'account_bank',
    //     'account_number',
    //     'amount',
    //     'email',
    //     'phone',
    //     'full_name',
    //     'status',
    //     'txn_id',
    //     'tx_ref'
    // ];
    protected $fillable = [
        'user_id',
        'currency',
        'network',
        'account_bank',
        'account_number',
        'amount',
        'email',
        'phone',
        'full_name',
        'status',
        'txn_id',
        'tx_ref'
    ];

    protected $hidden = ['created_at'];
}
