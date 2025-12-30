<?php

namespace User\App\Models\Paypal;

use Illuminate\Database\Eloquent\Model;

class Paypal extends Model
{
    protected $table = 'payments';

    protected $fillable = [
        'payment_id',
        'payer_id',
        'payer_email',
        'amount',
        'currency',
        'payment_status',
    ];
}
