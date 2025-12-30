<?php
namespace User\App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Member extends Authenticatable
{
  use  Notifiable;

    protected $table = 'ihook_members_table'; 
       protected $primaryKey = 'members_id';
     public $timestamps = false;

    protected $fillable = [
        'members_email',
        'members_password',
    ];

    protected $hidden = [
        'members_password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'members_password' => 'hashed', 
    ];

    public function getAuthPassword()
    {
        return $this->members_password;
    }


     public function getAuthIdentifierName()
    {
        return 'members_email'; 
    }

}
