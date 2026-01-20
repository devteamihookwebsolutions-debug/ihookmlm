<?php

/**
 * This class contains public functions related to MatrixConfiguration
 *
 * @package         MatrixConfiguration
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 0.1
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php

namespace User\App\Models\Member;

use Illuminate\Database\Eloquent\Model;

class MatrixConfiguration extends Model
{
    protected $table = 'ihook_matrix_configuration_table';
    public $timestamps = false;


    protected $fillable = [

        'matrix_key',
        'matrix_value',
        'matrix_id',
        'created_on',
        'created_by',
        // add other fields you want mass assignable here
    ];
}
