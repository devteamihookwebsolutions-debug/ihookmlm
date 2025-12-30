<?php

namespace Admin\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
 {
    use HasFactory;

    protected $table = 'ihook_wallettype';
    protected $primaryKey = 'wallet_type_id';
    public $timestamps = false;
    // Adjust if needed
}