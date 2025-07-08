<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'commission_rate',
        'currency',
        'payout_minimum',
        'payout_delay_days',
        'support_email',
        'site_name',
    ];
}
