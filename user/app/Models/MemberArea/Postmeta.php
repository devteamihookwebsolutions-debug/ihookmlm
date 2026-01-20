<?php

/**
 * This class contains public functions related to Postmeta
 *
 * @package         Postmeta
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

namespace User\App\Models\MemberArea;

use Illuminate\Database\Eloquent\Model;

class Postmeta extends Model
{
    protected $table = 'cart_postmeta';
    protected $primaryKey = 'meta_id';
    public $timestamps = false;

    protected $fillable = [
        'post_id', 'meta_key', 'meta_value',
    ];
}
