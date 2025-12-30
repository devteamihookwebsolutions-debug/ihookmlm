<?php
namespace User\App\Http\Controllers\Register\Middleware;
use Controller\BaseController;
use Model\Register\Middleware\MCheckPassword;
class CCheckPassword extends BaseController
{
   /**
     * This public static function is used to check password
     * @return boolean data
    */
    public static function checkpassword()
    {
       MCheckPassword::checkPassword();
    }
}
?>