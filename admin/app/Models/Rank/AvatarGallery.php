<?php

namespace Admin\App\Models\Rank;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvatarGallery extends Model
{
    use HasFactory;

    protected $table = 'ihook_avatar_gallery';
    protected $primaryKey = 'avatar_gallery_id';
    protected $fillable = [
        'avatar_gallery_id',
        'avatar_gallery_name',
        'avatar_gallery_path',
        'avatar_gallery_rank',
        'avatar_gallery_status',
    ];
    public $timestamps = false;
}