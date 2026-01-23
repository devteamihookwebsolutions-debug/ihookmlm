<?php

/**
 * This class contains public functions related to MDiscountGroup
 *
 * @package         MDiscountGroup
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
use Illuminate\Support\Facades\DB;
class MDiscountGroup
{

    public function checkDiscountGroupUser()
    {
        $prefix = config('services.ihook.prefix');
        $storeprefix = config('services.ihook.store_prefix');

        $groupid = request()->get('groupid', '');
        $useridParam = request()->get('userid', '');
        $discountgroup = '';

        if (empty($groupid) || empty($useridParam)) {
            echo '0';
            return;
        }

        $membersTable = $prefix . '_members_table';
        $groupLinkTable = $prefix . '_group_link_table';

        // Get the internal member id for the provided shop user id
        $memberId = DB::table($membersTable)
            ->where('members_shop_id', $useridParam)
            ->value('members_id');

        if (!$memberId) {
            echo '0';
            return;
        }

        $groupIds = array_values(array_filter(array_map('trim', explode(',', $groupid))));
        $found = [];

        foreach ($groupIds as $gid) {
            if ($gid === '') {
                continue;
            }
            $exists = DB::table($groupLinkTable)
                ->where('group_id', $gid)
                ->where('member_id', $memberId)
                ->exists();

            if ($exists) {
                $found[] = $gid;
            }
        }

        if (empty($found)) {
            echo '0';
            return;
        }

        echo implode(',', $found);
    }

    public function getDiscountGroup()
    {
        $prefix = config('services.ihook.prefix');
        $storeprefix = config('services.ihook.store_prefix');

        $table = $prefix . '_group_table';

        $records = DB::table($table)
            ->select('id', 'group_name')
            ->where('cart_status', 0)
            ->where('status', 0)
            ->get();

        $result = '';
        $recordCount = $records->count();

        foreach ($records as $i => $row) {
            $id = $row->id;
            $name = $row->group_name;

            $result .= '<p class="form-field _wc_custom_product_tabs_lite_tab_group_field ">';
            $result .= '<input type="hidden" name="_wc_custom_product_tabs_lite_tab_group' . $i . '" value="' . $id . '">';
            $result .= '<input type="hidden" name="_wc_custom_product_tabs_lite_tab_groupname' . $i . '" value="' . e($name) . '">';
            $result .= '<label for="_wc_custom_product_tabs_lite_tab_group">' . e($name) . '</label>';
            $result .= '<input type="text" name="tabdiscount' . $i . '" >';
            $result .= '<span class="woocommerce-help-tip"></span></p>';
        }

        $result .= '<input type="hidden" value="' . $recordCount . '" name="groupcount">';
        echo $result;
    }
}
