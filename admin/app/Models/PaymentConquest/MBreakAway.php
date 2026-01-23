<?php

/**
 * This class contains public functions related to MBreakAway
 *
 * @package         MBreakAway
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
?>
<?php
namespace Admin\App\Models\PaymentConquest;
use Admin\App\Models\Middleware\MMatrixConfiguration;
use Admin\App\Models\Middleware\MMemberDetails;
use Illuminate\Support\Facades\DB;

class MBreakAway
{

    public static function updateChangeSponsor($members_id, $matrix_id, $sponsor_id, $matrix_type_id)
    {
        $prefix = config('services.ihook.prefix');

        // Delete from previewgenealogy_table
        DB::table($prefix . 'previewgenealogy_table')
            ->where('matrix_id', $matrix_id)
            ->delete();

        // Get matrix level deep and width
        $level_deep = DB::table($prefix . 'matrix_configuration_table')
            ->where('matrix_id', $matrix_id)
            ->where('matrix_key', 'level_deep')
            ->value('matrix_value') ?? 0;

        $level_width = DB::table($prefix . 'matrix_configuration_table')
            ->where('matrix_id', $matrix_id)
            ->where('matrix_key', 'level_width')
            ->value('matrix_value') ?? 0;

        $originmembers_parents = [];

        // Rebuild preview genealogy (original logic)
        self::createProcedureQuery($matrix_id, $level_width, $level_deep);

        // Get original member link details
        $recordsoldlog = DB::table($prefix . 'matrix_members_link_table')
            ->where('members_id', $members_id)
            ->where('matrix_id', $matrix_id)
            ->first();

        if ($recordsoldlog) {
            $originmembersparents = $recordsoldlog->members_parents ?? '';
            $originmembers_parents = explode(',', $originmembersparents);

            // Get default sponsor from matrix configuration
            $default_sponsor = MMatrixConfiguration::getMatrixConfigurationDetails($matrix_id, 'default_sponsor');
            $default_sponsor = $default_sponsor[0]['matrix_value'] ?? 0;

            // Update member to default sponsor
            DB::table($prefix . 'matrix_members_link_table')
                ->where('members_id', $members_id)
                ->where('matrix_id', $matrix_id)
                ->update([
                    'direct_id' => $default_sponsor,
                    'spillover_id' => 0,
                    'members_parents' => '0',
                ]);

            // Update MongoDB
            $direct_details = MMemberDetails::getUserDetails($default_sponsor);
            $directby = $direct_details['members_username'] ?? '';
            // $where = ['members_id' => (int)$members_id, 'matrix_id' => $matrix_id];
            // $update = [
            //     'matrix.direct_id' => $default_sponsor,
            //     'matrix.direct_by' => $directby,
            //     'matrix.spillover_id' => '0',
            //     'matrix.members_parents' => '0'
            // ];
            // MUpdateCollection::updateCollection($update, $where, "members");

            // Set spillover
            MSpillover::setSpillover($members_id, $default_sponsor, $matrix_id, $matrix_type_id);

            // Update downline members
            $recordsdownline = DB::table($prefix . 'matrix_members_link_table')
                ->whereRaw("FIND_IN_SET(?, members_parents)", [$members_id])
                ->where('matrix_id', $matrix_id)
                ->orderBy('members_id', 'ASC')
                ->get();

            foreach ($recordsdownline as $downline) {
                $reqspilloverid = $downline->spillover_id;
                $reqmembers_id = $downline->members_id;

                $reqmember = DB::table($prefix . 'matrix_members_link_table')
                    ->where('members_id', $reqspilloverid)
                    ->where('matrix_id', $matrix_id)
                    ->first();

                $reqmembers_parents = $reqmember->members_parents ?? '';
                $reqmembers_root = ($reqmember->root ?? 0) + 1;
                $childrenmembers_parents = $reqmembers_parents . ',' . $reqspilloverid;

                DB::table($prefix . 'matrix_members_link_table')
                    ->where('members_id', $reqmembers_id)
                    ->where('matrix_id', $matrix_id)
                    ->where('direct_id', '>', 0)
                    ->update([
                        'root' => $reqmembers_root,
                        'members_parents' => $childrenmembers_parents
                    ]);

                // // Update MongoDB
                // $where = ['members_id' => (int)$reqmembers_id, 'matrix_id' => $matrix_id];
                // $update = [
                //     'matrix.root' => $reqmembers_root,
                //     'matrix.members_parents' => $childrenmembers_parents
                // ];
                // MUpdateCollection::updateCollection($update, $where, "members");
            }
        }
    }


    public static function createProcedureQuery($matrix_id, $width, $deep)
    {
        $prefix      = config('services.ihook.prefix');
        $storeprefix = config('services.ihook.store_prefix');


        DB::statement("DROP PROCEDURE IF EXISTS `my_proc`");
        DB::statement("
            CREATE PROCEDURE `my_proc` ()
            BEGIN
                DECLARE val1 INT DEFAULT NULL;
                DECLARE val2 INT DEFAULT NULL;
                DECLARE done TINYINT DEFAULT FALSE;

                DECLARE cursor1 CURSOR FOR
                    SELECT members_id, members_direct_id
                    FROM {$prefix}previewgenealogy_table
                    WHERE matrix_id = {$matrix_id}
                    AND members_account_status = '-1'
                    ORDER BY members_id ASC;

                DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

                OPEN cursor1;

                my_loop: LOOP
                    FETCH cursor1 INTO val1, val2;

                    IF done THEN
                        LEAVE my_loop;
                    ELSE
                        CALL user(val1, val2);
                    END IF;
                END LOOP;

                CLOSE cursor1;
            END
        ");


        DB::statement("DROP PROCEDURE IF EXISTS `user`");

        DB::statement("
            CREATE PROCEDURE `user` (
                IN livemembers_id BIGINT(40),
                IN direct_id BIGINT(40)
            )
            BEGIN
                DECLARE KnowsOldPassword INT DEFAULT 0;
                DECLARE knowschildrenmembersparents VARCHAR(240);
                DECLARE knowschildrenspilloverid INT;
                DECLARE endparents VARCHAR(500);
                DECLARE memlevelroot INT DEFAULT 0;
                DECLARE Knowsfillesstatus INT DEFAULT 0;

                SELECT COUNT(*) INTO KnowsOldPassword
                FROM {$prefix}matrix_members_link_table
                WHERE spillover_id = direct_id
                AND matrix_id = {$matrix_id};

                IF (KnowsOldPassword < {$width}) THEN

                    SELECT members_parents, members_id, root
                    INTO knowschildrenmembersparents, knowschildrenspilloverid, memlevelroot
                    FROM {$prefix}matrix_members_link_table
                    WHERE members_id = direct_id
                    AND matrix_id = {$matrix_id}
                    LIMIT 1;

                    IF (knowschildrenmembersparents > 0) THEN
                        SET endparents = CONCAT(knowschildrenmembersparents, ',', knowschildrenspilloverid);
                    ELSE
                        SET endparents = knowschildrenspilloverid;
                    END IF;

                    SET memlevelroot = memlevelroot + 1;

                    UPDATE {$prefix}matrix_members_link_table
                    SET root = memlevelroot,
                        members_parents = endparents,
                        members_account_status = '1'
                    WHERE members_id = livemembers_id
                    AND matrix_id = {$matrix_id};

                    SET knowschildrenspilloverid = direct_id;

                ELSE

                    SELECT members_parents, members_id, root
                    INTO knowschildrenmembersparents, knowschildrenspilloverid, memlevelroot
                    FROM {$prefix}matrix_members_link_table
                    WHERE FIND_IN_SET(direct_id, members_parents)
                    AND members_filled_status = '0'
                    AND matrix_id = {$matrix_id}
                    ORDER BY members_id ASC
                    LIMIT 1;

                    SET endparents = CONCAT(knowschildrenmembersparents, ',', knowschildrenspilloverid);
                    SET memlevelroot = memlevelroot + 1;

                    UPDATE {$prefix}matrix_members_link_table
                    SET root = memlevelroot,
                        members_parents = endparents,
                        members_account_status = '1'
                    WHERE members_id = livemembers_id
                    AND matrix_id = {$matrix_id};

                    SELECT COUNT(*) INTO Knowsfillesstatus
                    FROM {$prefix}matrix_members_link_table
                    WHERE spillover_id = knowschildrenspilloverid
                    AND matrix_id = {$matrix_id};

                    IF (Knowsfillesstatus > {$width}) THEN
                        UPDATE {$prefix}matrix_members_link_table
                        SET members_filled_status = '1'
                        WHERE members_id = knowschildrenspilloverid
                        AND matrix_id = {$matrix_id};
                    END IF;

                END IF;

                UPDATE {$prefix}previewgenealogy_table
                SET members_account_status = '1'
                WHERE members_id = livemembers_id
                AND matrix_id = {$matrix_id};

            END
        ");
    }

}
