<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    protected $fillable = ['user_id', 'balance', 'amount'];

    public function withdrawals(): HasMany {
        return $this->hasMany(Withdrawal::class);
    }
}
