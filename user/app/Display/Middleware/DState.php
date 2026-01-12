<?php
/**
* This class contains public static functions related to state list .
*
* @package         DState
* @category        Display
* @author          Sunsofty Dev Team
* @link            https://promlmsoftware.com
* @copyright       Copyright (c) 2020 - 2023, Sunsofty.
* @version         Version 8.1
*/
/****************************************************************************
* Licence Agreement: 
*     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@promlmsoftware.com.
*****************************************************************************/
?>
<?php
namespace Display\Middleware;
class DState
{
    /**
     * This public static function is used to show state list
     * @param array  $records
     * @return HTML data
     */
    public static function getStatesList($records) {
      $state_id = trim($_POST['state_id']);
      for ($i = 0; $i < count((array)$records); $i++) {
          if ($records[$i]['state_code'] == $state_id) {
              $output .= '<option selected value="' . $records[$i]['state_code'] . '">' . $records[$i]['state_name'] . '</option>';
          }else{
              $output .= '<option value="' . $records[$i]['state_code'] . '">' . $records[$i]['state_name'] . '</option>';
          }
      }
      return $output;
  }
    /**
     * This public static function is used to show state list
     * @param array  $records
     * @return HTML data
     */
    public static function showStatesList($records,$state_id) {
        for ($i = 0; $i < count((array)$records); $i++) {
            if ($records[$i]['state_code'] == $state_id) {
                $output .= '<option selected value="' . $records[$i]['state_code'] . '">' . $records[$i]['state_name'] . '</option>';
            }else{
                $output .= '<option value="' . $records[$i]['state_code'] . '">' . $records[$i]['state_name'] . '</option>'; 
            }
        }
        return $output;
    }

}
?>