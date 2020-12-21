<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Wallet
 *
 */
class Wallet extends Model
{
    protected $fillable = ['user_id', 'balance'];

    /**
     * @return HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }

}
