<?php

/**
 * This class contains public functions related to AvatarGallery
 *
 * @package         AvatarGallery
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

namespace Admin\App\Models\Rank;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvatarGallery extends Model
{
    use HasFactory;

    protected $table;
    protected $primaryKey = 'avatar_gallery_id';
     public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $prefix = config('services.ihook.prefix');
        $this->table = $prefix . '_avatar_gallery';
    }

    protected $fillable = [
        'avatar_gallery_id',
        'avatar_gallery_name',
        'avatar_gallery_path',
        'avatar_gallery_rank',
        'avatar_gallery_status',
    ];
    public $timestamps = false;
}
