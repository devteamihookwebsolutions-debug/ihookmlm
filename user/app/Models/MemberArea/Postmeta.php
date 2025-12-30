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
