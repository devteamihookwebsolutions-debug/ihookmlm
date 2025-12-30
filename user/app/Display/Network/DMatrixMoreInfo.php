<?php
/**
 * This class contains public static functions related to user network
 *
 * @package         DMatrixMoreInfo
 * @category        Display
 * @author          Sunsofty Dev Team
 * @link            https://sunsoftny.com
 * @copyright       Copyright (c) 2020 - 2023, Sunsofty.
 * @version         Version 8.1
 */
/****************************************************************************
 * Licence Agreement: 
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@sunsoftny.com.
 *****************************************************************************/
?><?php
namespace Display\Network;
class DMatrixMoreInfo
{
    /**
     * This public static function is used to show  network  Referral details of member
     * @param array  $records
     * @return HTML data
     */
    public static function showMatrixMoreInformation($records)
    {
        $output = '<div class="portlet light about-text">
                                  <div class="row">
                                    <div class="col-md-6">
                                        <ul class="list-unstyled margin-top-10 margin-bottom-10">
                                             <li>
                                            <h3>  ' . $records['matrix_name'] . '  </h3></li> 
                                            <li>
                                              ' . $records['matrix_description'] . '  </li>                                  
                                        </ul>
                                    </div>
                                </div>
                            </div>';
        echo $output;
    }
}
?>    