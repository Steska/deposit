<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    const ADD_BALANCE = 'enter';
    const CREATE_DEPOSIT = 'create_deposit';
    const CLOSE_DEPOSIT = 'close_deposit';

    protected $fillable = [
        'user_id',
        'wallet_id',
        'deposit_id',
        'amount',
        'type',
    ];
}
