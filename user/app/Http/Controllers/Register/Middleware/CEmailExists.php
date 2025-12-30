<?php
namespace User\App\Http\Controllers\Register\Middleware;
use Controller\BaseController;
use User\App\Model\Register\Middleware\MEmailExists;


class CEmailExists extends BaseController
{
    /**
      * This public static function is used to check exists user email
      * @return boolean data
     */
    public  function checkUserEmailExists()
    {
        MEmailExists::checkUserEmailExists();
    }

    public  function checkRecruitEmailExists()
    {
        MEmailExists::checkRecruitEmailExists();
    }

}
?>