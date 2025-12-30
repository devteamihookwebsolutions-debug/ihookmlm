<?php
namespace Admin\App\Models\Member;

use Illuminate\Database\Eloquent\Model;

class TerminologySetting extends Model
{
    protected $table = 'ihook_terminology_settings_table';

     protected $fillable = ['language_key', 'language_value', 'language', 'type', 'updatedat'];
     public $timestamps = false;

}