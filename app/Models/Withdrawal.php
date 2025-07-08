<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Withdrawal extends Model
{
    protected $fillable = ['account_id', 'phone_number', 'payment_method', 'amount'];

    public function account(): BelongsTo {
        return $this->belongsTo(Account::class);
    }
}
