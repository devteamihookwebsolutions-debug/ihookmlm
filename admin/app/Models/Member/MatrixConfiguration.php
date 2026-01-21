<?php

/**
 * This class contains public functions related to MatrixConfiguration
 *
 * @package         MatrixConfiguration
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php

namespace Admin\App\Models\Member;

use Illuminate\Database\Eloquent\Model;

class MatrixConfiguration extends Model
{
    protected $table;
    protected $primaryKey = 'matrix_configuration_id';
         public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $prefix = config('services.ihook.prefix');
        $this->table = $prefix . '_matrix_configuration_table';
    }
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'matrix_configuration_id',
        'matrix_key',
        'matrix_value',
        'matrix_id',
        'created_on',
        'created_by',
    ];
}
