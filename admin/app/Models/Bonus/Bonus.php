<?php

namespace Admin\App\Models\Bonus;

use Admin\App\Models\MatrixConfig\MMatrix;
use Admin\App\Models\Wallet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Bonus extends Model
{
    protected $table = 'ihook_bonus';
    protected $primaryKey = 'bonusid';
    public $incrementing = true;
    protected $keyType = 'int';

    public $timestamps = false; // Since createdon/updatedon are manual

    protected $fillable = [
        'bonus_name', 'matrix_id', 'periodstatus', 'reward', 'amount',
        'giftname', 'bonustype', 'period', 'workson', 'bonus_to',
        'maximumlimit', 'admin_approve_bonus', 'accountype',
        'crypto_currency', 'crypto_currency_id', 'bonusday', 'bonusmonth',
        'bonus_status', 'createdby', 'updatedby', 'createdon', 'updatedon'
    ];

    // === DATE CASTING (Fixes "format() on string" error) ===
    protected $casts = [
        'createdon' => 'datetime',
        'updatedon' => 'datetime',
        'bonusday'  => 'integer',
        'bonusmonth'=> 'integer',
        'periodstatus' => 'boolean',
        'admin_approve_bonus' => 'boolean',
        'bonus_status' => 'boolean',
        'reward' => 'boolean',
        'bonus_to' => 'boolean',
    ];

    // === RELATIONSHIPS ===
    public function matrix()
    {
        return $this->belongsTo(MMatrix::class, 'matrix_id', 'matrix_id');
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class, 'accountype', 'wallet_type_id');
    }

    // === ACCESSORS (Indian Format) ===

    /**
     * Get createdon in Indian format: 24-10-2025
     */
    protected function createdOn(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? \Carbon\Carbon::parse($value)->format('d-m-Y') : '—'
        );
    }

    /**
     * Get updatedon in Indian format with time: 24-10-2025 03:45 PM
     */
    protected function updatedOn(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? \Carbon\Carbon::parse($value)->format('d-m-Y h:i A') : '—'
        );
    }

    /**
     * Optional: Format bonusday & bonusmonth as 2 digits (01, 02, etc.)
     */
    protected function bonusDay(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? sprintf('%02d', $value) : '—'
        );
    }

    protected function bonusMonth(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? sprintf('%02d', $value) : '—'
        );
    }
}