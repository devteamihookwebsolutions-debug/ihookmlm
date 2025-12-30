<?php
namespace User\App\Models\Register\Middleware;
use User\App\Models\Member;

class MNameExists
{
    /**
     * This public static function is used to check exists username
     * @return boolean data
     */
    public  function checkUserNameExists($username)
    {
          $username = trim($username);

        return  Member::where('members_username', $username)->exists();

        
    }

    
   
   

}