<?php
namespace User\App\Models\Register\Middleware;
use User\App\Models\Member;


class MEmailExists{
    /**
     * This public static function is used to check exists user email
     * @return boolean data
    */
  

    public function checkRegisterEmailExists($email)
    {
        
	$email = trim($email);

    return Member::where('members_email', $email)->exists();
   

    }
	
	
}
?>