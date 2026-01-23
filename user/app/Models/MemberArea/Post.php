<?php

/**
 * This class contains public functions related to Post
 *
 * @package         Post
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

class Post extends Model
{
    protected $table;
    protected $primaryKey = 'ID';
    public $timestamps = false;

    public function meta()
    {
        return $this->hasMany(Postmeta::class, 'post_id', 'ID');
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $prefix = config('services.ihook.store_prefix');
        $this->table = $prefix . '_posts';
    }
}
