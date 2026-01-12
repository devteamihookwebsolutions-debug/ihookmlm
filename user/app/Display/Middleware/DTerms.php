<?php
/**
 * This class contains public static functions related to terms
 *
 * @package         DTerms
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
?>
<?php
namespace Display\Middleware;


class DTerms{
    /**
     * This public static function is used to get all terms
     * @param int  $type
     * @return HTML data
    */
    public static function getAllTerms($records, $type)
    {
        for ($i = 0; $i < count((array)$records); $i++) {
            $j         = $i + 1;
            $condition = $records[$i]['terms_condition'];
            $title     = $records[$i]['terms_title'];
            $terms_id  = $records[$i]['terms_id'];
            if ($type == 2) {
                $output .= '<label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                <input class="clschk m-input"  aria-label="label" type="checkbox" name="terms1" value="1" id="checkbox1_' . $j . '" required="true" >' . __('I acknowledge that I have read and agree to be bound to the terms included in the agreement') . ' ' . $title . ' <a aria-label="link" href="javascript:void(0);" onclick="showtermscondition(' . $terms_id . ');">' . __('terms of service') . '</a>
                <span></span></label><br>';
            }
            if ($type == 3) {
                $output .= '<label class="m-checkbox m-checkbox--solid m-checkbox--brand col-lg-12">
                    <input aria-label="label" type="checkbox" name="terms1" value="1" id="checkbox1_' . $j . '" required><a aria-label="link" href="javascript:void(0);" onclick="showtermscondition(' . $terms_id . ');">' . __('I acknowledge that I have read and agree to be bound to the terms included in the agreement') . '</a>
                    <span></span>
                </label><br>';
            }
            if ($type == 1) {
                $output .= '<label class="m-checkbox m-checkbox--solid m-checkbox--brand d-block">
                                    <input aria-label="label" type="checkbox" name="terms1" value="1" id="checkbox1_' . $j . '" required><a aria-label="link" href="javascript:void(0);" onclick="showtermscondition(' . $terms_id . ');"> ' . __('I acknowledge that I have read and agree to be bound to the terms included in the agreement') . '</a>
                                    <span></span>
                                </label>';
            }
            
        }
        // echo'<pre>';print_r($output);exit;
        return $output;
    }
    
}
?>