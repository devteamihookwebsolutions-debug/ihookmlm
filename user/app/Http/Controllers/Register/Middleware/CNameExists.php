<?php
namespace User\App\Http\Controllers\Register\Middleware;
use Controller\BaseController;
use Models\Register\Middleware\MNameExists;
class CNameExists extends BaseController
{
    /**
     * This public static function is used to check exists username
     * @return boolean data
    */
    public static function checkUserNameExists()
    {
       $username = $request->input('members_username');

        $exists = Member::where('members_username', $username)->exists();

        if ($exists) {
            return response()->json(false); // username exists
        } else {
            return response()->json(true); // username does not exist
        }
    }
	
	public static function checkUserMemberNameExists()
    {		

      MNameExists::checkUserMemberNameExists();
    }
	
	public static function checkUserSubdomainExists()
    {		
       MNameExists::checkUserSubdomainExists();
    }
	
    public static function checkUserSubdomainExistsNew()
    {		
        // echo'<pre>';print_r($_POST);exit;
        MNameExists::checkUserSubdomainExistsNew();
    }
	public static function checkUserSubdomainExistsRegister()
    {		
       MNameExists::checkUserSubdomainExistsRegister();
    }
}
?>