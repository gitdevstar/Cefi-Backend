<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'pair',
        'amount',
        'side',
        'price',
        'status',
        'txn_id',
    ];

    protected $hidden = ['created_at', 'txn_id'];
}
