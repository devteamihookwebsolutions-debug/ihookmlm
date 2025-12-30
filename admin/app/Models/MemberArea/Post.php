<?php

namespace Admin\App\Models\MemberArea;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'cart_posts';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    public function meta()
    {
        return $this->hasMany(Postmeta::class, 'post_id', 'ID');
    }
}
