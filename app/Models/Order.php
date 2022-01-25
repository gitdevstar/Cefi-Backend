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
        'txn_id',
    ];

    protected $hidden = ['created_at', 'updated_at'];
}