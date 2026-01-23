<?php
/**
 * This class contains public static functions related to discount group.
 *
 * @package         MWordPressDiscountGroup
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@promlmsoftware.com.
*****************************************************************************/
?>
<?php
namespace Admin\App\Models\Wordpress;
use Admin\App\Display\Wordpress\DWordPressDiscountGroup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Request;

class MWordPressDiscountGroup {


    public static function showGroup()
    {
        $prefix = config('services.ihook.prefix');
        $groupTable = $prefix . '_group_table';

        // Define the columns
        $columns = ['id', 'group_name', 'status', 'cart_status'];

        // Get all records
        $records = DB::table($groupTable)
            ->select($columns)
            ->get()
            ->toArray(); // Convert to array if needed

        // Get total count
        $iTotal = DB::table($groupTable)->count();

        // Call the existing function with records and total
        return DWordPressDiscountGroup::showGroup($records, $iTotal);
    }

    public static function updateGroup()
    {
        $prefix = config('services.ihook.prefix'); // e.g., 'promlm_'
        $groupTable = $prefix . '_group_table';

        // Get POST values safely
        $groupName = trim(request()->post('group_name'));
        $status = request()->post('status') === '1' ? 1 : 0;
        $cartStatus = request()->post('cart_status') === '1' ? 1 : 0;

        // Insert into database
        $inserted = DB::table($groupTable)->insert([
            'group_name'  => $groupName,
            'status'      => $status,
            'cart_status' => $cartStatus
        ]);

        // Set session messages
        if ($inserted) {
            Session::flash('success_message', __('Group has been added successfully'));
        } else {
            Session::flash('error_message', __('Unable to Add, please add once again'));
        }
    }


    public static function editGroup()
    {
        $prefix = config('services.ihook.prefix');
        $groupTable = $prefix . '_group_table';

        $id = request()->query('sub1');
        $id = (ctype_digit($id)) ? (int) $id : null;

        if (!$id) {
            return null; // or throw exception if needed
        }

        // Fetch the record
        $record = DB::table($groupTable)
            ->where('id', $id)
            ->first(); // returns stdClass object

        return $record;
    }

    public static function editUpdateGroup()
    {
        $prefix = config('services.ihook.prefix'); // e.g., 'promlm_'
        $groupTable = $prefix . '_group_table';

        $id = Request::post('group_id');
        $status = Request::post('status') === '1' ? 1 : 0;
        $cartStatus = Request::post('cart_status') === '1' ? 1 : 0;
        $groupName = trim(Request::post('group_name'));

        $updated = DB::table($groupTable)
            ->where('id', $id)
            ->update([
                'group_name'  => $groupName,
                'status'      => $status,
                'cart_status' => $cartStatus
            ]);

        if ($updated) {
            Session::flash('success_message', __('Group has been updated successfully'));
        } else {
            Session::flash('error_message', __('Unable to Update, please try again'));
        }
    }

    public static function deleteGroup()
    {
        $prefix = config('services.ihook.prefix'); // e.g., 'promlm_'
        $groupTable = $prefix . '_group_table';
        $groupLinkTable = $prefix . '_group_link_table';

        $id = Request::query('sub1');

        // Delete from group_table
        $deleted = DB::table($groupTable)->where('id', $id)->delete();

        if ($deleted) {
            Session::flash('success_message', __('User Group has been deleted successfully'));
        } else {
            Session::flash('error_message', __('User Group has not been deleted'));
        }

        // Delete related links from group_link_table
        DB::table($groupLinkTable)->where('group_id', $id)->delete();

        return true;
    }

    public static function showGroupUsers()
    {
        $prefix = config('services.ihook.prefix'); // e.g., 'promlm_'
        $groupLinkTable = $prefix . '_group_link_table';

        $groupId = Request::query('sub1');

        // Fetch records
        $records = DB::table($groupLinkTable)
            ->select('id', 'group_id', 'member_id')
            ->where('group_id', $groupId)
            ->get()
            ->toArray();

        // Get total count
        $iTotal = DB::table($groupLinkTable)
            ->where('group_id', $groupId)
            ->count();

        return DWordPressDiscountGroup::showGroupUsers($records, $iTotal);
    }



    public static function showUsers()
    {
        $prefix = config('services.ihook.prefix'); // e.g., 'promlm_'
        $membersTable = $prefix . '_members_table';

        $columns = ['members_id', 'members_username', 'members_email', 'members_doj', 'members_status'];

        // Fetch all members
        $records = DB::table($membersTable)
            ->select($columns)
            ->get()
            ->toArray();

        // Get total count
        $iTotal = DB::table($membersTable)->count();

        return DWordPressDiscountGroup::showUsers($records, $iTotal);
    }

    public static function usersUpdateGroup()
    {
        $prefix = config('services.ihook.prefix'); // e.g., 'promlm_'
        $groupTable = $prefix . '_group_table';
        $groupLinkTable = $prefix . '_group_link_table';

        if (Session::has('groupid') && Session::has('grpid')) {
            $grpid = Session::get('groupid');
            $arr = explode(',', Session::get('grpid'));

            if (!empty($arr)) {
                foreach ($arr as $memberId) {
                    DB::table($groupLinkTable)->insert([
                        'group_id'  => $grpid,
                        'member_id' => $memberId
                    ]);
                }
            } else {
                // If no existing group, create a new group
                $status = Request::post('status') === '1' ? 1 : 0;
                $cartStatus = Request::post('cart_status') === '1' ? 1 : 0;
                $groupName = trim(Request::post('group_name'));

                $newGroupId = DB::table($groupTable)->insertGetId([
                    'group_name'  => $groupName,
                    'status'      => $status,
                    'cart_status' => $cartStatus
                ]);

                // Insert members into the new group
                foreach ($arr as $memberId) {
                    DB::table($groupLinkTable)->insert([
                        'group_id'  => $newGroupId,
                        'member_id' => $memberId
                    ]);
                }

                // Clear session variables
                Session::forget('grpid');
                Session::forget('groupid');

                Session::flash('success_message', __('Group has been added successfully'));
            }
        }
    }

    public static function checkGroupName()
    {
        $prefix = config('services.ihook.prefix'); // e.g., 'promlm_'
        $groupTable = $prefix . '_group_table';

        $groupName = trim(Request::post('group_name'));
        $excludeId = Request::query('sub1'); // optional exclusion ID

        $query = DB::table($groupTable)->where('group_name', $groupName);

        if (!empty($excludeId)) {
            $query->where('id', '!=', $excludeId);
        }

        $count = $query->count();

        echo $count > 0 ? 'false' : 'true';
        exit;
    }

}
