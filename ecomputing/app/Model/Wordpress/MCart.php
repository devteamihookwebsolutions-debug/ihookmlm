<?php

/**
 * This class contains public functions related to MCart
 *
 * @package         MCart
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?><?php
namespace Ecomputing\App\Model\Wordpress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MCart
{
    public function checkGroupUser(Request $request)
    {
        $grpid  = $request->input('groupid');
        $shopId = $request->input('userid');
        $arr    = [];
        $found  = false;

        $prefix = config('services.ihook.prefix');

        $member = DB::table($prefix . '_members_table')
            ->where('members_shop_id', $shopId)
            ->first();

        if (!$member) {
            return response()->json(['status' => 'error', 'message' => 'Member not found']);
        }

        $memberId = $member->members_id;
        $groupIds = explode(',', $grpid);

        foreach ($groupIds as $groupId) {
            $link = DB::table($prefix . '_group_link_table')
                ->where('group_id', $groupId)
                ->where('member_id', $memberId)
                ->first();

            if ($link) {
                $arr[] = $groupId;
                $found = true;
            }
        }

        if (!$found) {
            $arr = [0];
        }

        return implode(',', $arr);
    }

    public function getGroup()
    {
        $prefix = config('services.ihook.prefix');

        $groups = DB::table($prefix . '_group_table')
            ->where('cart_status', 0)
            ->where('status', 0)
            ->get();

        $html = '';
        $count = $groups->count();

        foreach ($groups as $i => $group) {
            $html .= '<p class="form-field _wc_custom_product_tabs_lite_tab_group_field ">';
            $html .= '<input type="hidden" name="_wc_custom_product_tabs_lite_tab_group' . $i . '" value="' . $group->id . '">';
            $html .= '<input type="hidden" name="_wc_custom_product_tabs_lite_tab_groupname' . $i . '" value="' . $group->group_name . '">';
            $html .= '<label for="_wc_custom_product_tabs_lite_tab_group">' . $group->group_name . '</label>';
            $html .= '<input type="text" name="tabdiscount' . $i . '" >';
            $html .= '<span class="woocommerce-help-tip"></span></p>';
        }

        $html .= '<input type="hidden" value="' . $count . '" name="groupcount">';

        return $html;
    }
}
