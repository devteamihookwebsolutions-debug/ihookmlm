<?php

/**
 * This class contains public functions related to PartySetup
 *
 * @package         PartySetup
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
?>
<?php

namespace User\App\Models\MemberArea;

use Illuminate\Database\Eloquent\Model;

class PartySetup extends Model
{
    protected $table;   // your table name
    public $timestamps = false;               // no created_at/updated_at
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'setup_party_id', 'setup_name', 'setup_value', 'status'
    ];

     public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $prefix = config('services.ihook.prefix');
        $this->table = $prefix . '_party_setup';
    }
}
