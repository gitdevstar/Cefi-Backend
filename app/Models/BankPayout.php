<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankPayout extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'currency',
        'account_bank',
        'account_number',
        'amount',
        'fee',
        'email',
        'full_name',
        'txn_id',
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
