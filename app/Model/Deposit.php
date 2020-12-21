<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    const PERCENT = 20;
    const ACTIVE = 1;
    const NO_ACTIVE = 0;
    const DURATION = 20;
    const ACCRUE_TIMES = 20;

    protected $fillable = [
        'user_id',
        'wallet_id',
        'invested',
        'percent',
        'active',
        'duration',
        'accrue_times',
    ];
}
