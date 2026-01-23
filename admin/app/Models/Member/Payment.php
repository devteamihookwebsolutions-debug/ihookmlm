<?php

/**
 * This class contains public functions related to Payment
 *
 * @package         Payment
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?><?php
namespace Admin\App\Models\Member;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table;
    protected $primaryKey = 'paymentsettings_id';
        public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $prefix = config('services.ihook.prefix');
        $this->table = $prefix . '_paymentsettings_table';
    }
    public $timestamps = false;

    protected $fillable = [
        'paymentsettings_accname',
        'paymentsettings_accnum',
        'paymentsettings_status',
        'instantpayout_status',
        'payout_apivalues',
        'paymentsettings_mode',
        'paymentsettings_name',
        'paymentsettings_default_name',
        'paymentsettings_image_path',
        'paymentsettings_description',
        'paymentsettings_type'
    ];
}
