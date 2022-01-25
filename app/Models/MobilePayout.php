<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobilePayout extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'currency',
        'type',
        'amount',
        'email',
        'phone',
        'full_name',
        'fee',
        'txn_id',
    ];

    protected $hidden = ['created_at', 'updated_at'];
}