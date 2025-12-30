<?php

/**
 * This class contains public static functions related to genealogy
 *
 * @package         MCompactGenealogy
 * @category        Model
 * @author          Sunsofty Dev Team
 * @link            https://sunsoftny.com
 * @copyright      Copyright (c) 2020 - 2023, Sunsofty.
 * @version        Version 8.1
 */
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@sunsoftny.com.
 *****************************************************************************/
?><?php

    namespace Admin\App\Model\Genealogy;

    use Admin\App\Models\Genealogy\MBinaryLinkDetails;
    use Admin\App\Models\Genealogy\MBinaryMembersCount;
    use Admin\App\Models\Middleware\MBinaryMembersPosition;
    use Admin\App\Models\Middleware\MURLCrypt;


    class MBinaryCompactGenealogy
    {
        /**
         * This public static function is used  to get genealogy data
         * @param int $members_id
         * @param int $matrix_id
         * @return bool
         */
        public static function getCompactGenealogytree($members_id, $matrix_id)
        {
// dd($members_id ,$matrix_id);
            $output = '';
            $binaryparentdetails   = MBinaryLinkDetails::getBinaryLinkDetails($members_id, $matrix_id);
            $direct_id             = $binaryparentdetails['direct_id'];
            $matrix_doj            = $binaryparentdetails['matrix_doj'];
            $spillover_id          = $binaryparentdetails['spillover_id'];
            $members_username      = $binaryparentdetails['membername'];
            $members_phone         = $binaryparentdetails['members_phone'];
            $members_email         = $binaryparentdetails['members_email'];
            $members_image         = $binaryparentdetails['members_image'];
            $parentroot            = $binaryparentdetails['root'];
            $ranktitle             = $binaryparentdetails['ranktitle'];
            $sponsor_username      = $binaryparentdetails['sponsor_username'];
            $sponsor_username      = $direct_id > '0' ? $sponsor_username : 'Nil';
            $rankid                = $binaryparentdetails['rankid'];
            $rank_icon_path        = $binaryparentdetails['rank_value'];

            $leftuser = MBinaryMembersPosition::getBinaryMembersPosition($members_id, $matrix_id, '1');
            $rightuser = MBinaryMembersPosition::getBinaryMembersPosition($members_id, $matrix_id, '2');

            $rank_icon_path        = $rankid == '' ? '0' : $rank_icon_path;
            $targetroot            = $parentroot + 3;
            $parentcontacttemplate = $rankid > '0' ? 'contactTemplate' : 'contactTemplate1';
            $memberimage           = $members_image != '' ? $_ENV['CDNCLOUDEXTURL'] . '/' . $members_image : '' . $_ENV['UI_ASSET_URL'] . '/img/compact_emptyavatar.png';
            if (empty($rank_icon_path)) {
                $rank_icon_path = '';
            } else {
                $rank_icon_path = $_ENV['CDNCLOUDEXTURL'] . '/' . $rank_icon_path;
            }
            $count                 = MBinaryMembersCount::getBinaryMemberscount($members_id, $matrix_id);
            $leftcount             = $count['left'];
            $rightcount            = $count['right'];
            $lefttotalmember       = $leftcount;
            $righttotalmember      = $rightcount;
            $rank                  = $ranktitle == '' ? 'Nil' : $ranktitle;

            $crypturl = MURLCrypt::getEncryptURL($matrix_id, $members_id);
// dd($crypturl);
            $output .= '
            <!-- hv-container -->
            <div class="bg-white dark:bg-neutral-900 flex min-h-screen flex-col items-center justify-start p-2 py-10 text-center overflow-auto">
            <div class="tree whitespace-nowrap overflow-auto relative mx-auto" data-testid="family-tree-root">
            <ul class="relative flex flex-row items-baseline justify-center">';

            $output .= ' <li class="float-left list-none relative pt-14 px-2 mt-0">
                    <div class="border-solid border-neutral-300 border p-2 rounded-md inline-block">
                        <div class="!border-none py-1 px-2 inline-block" data-testid="person-container">
                            <span role="img" aria-label="Avatar for  ' . $members_username . '" title="Avatar for queen anga" class="bg-female inline-block relative h-10 w-10 cursor-pointer overflow-hidden rounded-full ">
                                <a href="' . '/user' . '/network/view/' . $crypturl . '"><img src="' . $memberimage . '" alt="" class="w-10 h-10 rounded-full overflow-hidden bg-white"></a>
                            </span>
                            <p class="m-0 text-black dark:text-white"> ' . $members_username . '</p>
                        </div>';
            if ($rank_icon_path != '') {
                $output .= '<div class="rank"><img name="rankphoto" class="block mx-auto w-8 h-8" src="' . $rank_icon_path . '" title="' . $rank . '"></div>';
            }

            $output .= '</div><ul class="pt-14 relative flex flex-row items-baseline justify-center">';

            if ($leftuser > 0) {

                //showleftdetails
                $binaryleftdetails         = MBinaryLinkDetails::getBinaryLinkDetails($leftuser, $matrix_id, $targetroot);
                $leftdirect_id             = $binaryleftdetails['direct_id'];
                $leftmatrix_doj            = $binaryleftdetails['matrix_doj'];
                $leftmembers_username      = $binaryleftdetails['membername'];
                $leftmembers_email         = $binaryleftdetails['members_email'];
                $leftmembers_members_phone = $binaryleftdetails['members_phone'];
                $leftmembers_image         = $binaryleftdetails['members_image'];
                $leftranktitle             = $binaryleftdetails['ranktitle'];
                $leftsponsor_username      = $binaryleftdetails['sponsor_username'];
                $leftsponsor_username      = $leftdirect_id > '0' ? $leftsponsor_username : 'Nil';
                $leftrankid                = $binaryleftdetails['rankid'];
                $leftrank_icon_path        = $binaryleftdetails['rank_value'];
                $leftmembers_image         = $leftmembers_image != '' ? $_ENV['CDNCLOUDEXTURL'] . '/' . $leftmembers_image : '' . $_ENV['UI_ASSET_URL'] . '/img/compact_emptyavatar.png';
                if (empty($leftrank_icon_path)) {
                    $leftrank_icon_path = '';
                } else {
                    $leftrank_icon_path = $_ENV['CDNCLOUDEXTURL'] . '/' . $leftrank_icon_path;
                }
                $leftcontacttemplate       = $leftrankid > '0' ? 'contactTemplate' : 'contactTemplate1';
                $count                     = MBinaryMembersCount::getBinaryMemberscount($leftuser, $matrix_id);
                $leftcount                 = $count['left'];
                $rightcount                = $count['right'];
                $lefttotalmember           = $leftcount;
                $righttotalmember          = $rightcount;
                $leftranktitle             = $leftranktitle == '' ? 'Nil' : $leftranktitle;
                $leftcrypturl = MURLCrypt::getEncryptURL($matrix_id, $leftuser);


                $output .= '<li class="float-left list-none relative pt-14 px-2 mt-0">
            <div class="border-solid border-neutral-300 border p-2 rounded-md inline-block">
                            <div class="!border-none py-1 px-2 inline-block" data-testid="person-container">
                                <span role="img" aria-label="Avatar for ish" title="Avatar for ish" class="bg-male inline-block relative h-10 w-10 cursor-pointer overflow-hidden rounded-full ">
                                    <a href="' .'/user' . '/network/view/' . $leftcrypturl . '"><img src="' . $leftmembers_image . '" alt=""  class="w-10 h-10 rounded-full overflow-hidden bg-white"></a>
                                </span>
                                <p class="m-0 text-black dark:text-white">' . $leftmembers_username . '</p>
                            </div>';
                if ($leftrank_icon_path != '') {
                    $output .= '<div class="rank"><img name="rankphoto" style="height: 40px;width:40px;" src="' . $leftrank_icon_path . '" class="w-10 h-10 rounded-full overflow-hidden bg-white" title="' . $rank . '"></div>';
                }
                $output .= '</div>';


                $output .= self::getDepthCompactGenealogy($leftuser, $matrix_id, $targetroot);

                $output .= '</li>';
            } else {
                $output .= self::getEmptyCompactGenealogytree($leftuser, $matrix_id, '1');
            }
            if ($rightuser > 0) {
                //showrightdetails
                $binaryrightdetails    = MBinaryLinkDetails::getBinaryLinkDetails($rightuser, $matrix_id, $targetroot);
                $rightdirect_id        = $binaryrightdetails['direct_id'];
                $rightmatrix_doj       = $binaryrightdetails['matrix_doj'];
                $rightmembers_username = $binaryrightdetails['membername'];
                $rightmembers_phone    = $binaryrightdetails['members_phone'];
                $rightranktitle        = $binaryrightdetails['ranktitle'];
                $rightmembers_email    = $binaryrightdetails['members_email'];
                $rightmembers_image    = $binaryrightdetails['members_image'];
                $rightsponsor_username = $binaryrightdetails['sponsor_username'];
                $rightsponsor_username = $rightdirect_id > '0' ? $rightsponsor_username : 'Nil';
                $rightrankid           = $binaryrightdetails['rankid'];
                $rightrank_icon_path   = $binaryrightdetails['rank_value'];
                $rightmembers_image    = $rightmembers_image != '' ? $_ENV['CDNCLOUDEXTURL'] . '/' . $rightmembers_image : '' . $_ENV['UI_ASSET_URL'] . '/img/compact_emptyavatar.png';
                if (empty($rightrank_icon_path)) {
                    $rightrank_icon_path = '';
                } else {
                    $rightrank_icon_path = $_ENV['CDNCLOUDEXTURL'] . '/' . $rightrank_icon_path;
                }

                $rightcontacttemplate  = $rightrankid > '0' ? 'contactTemplate' : 'contactTemplate1';
                $count                 = MBinaryMembersCount::getBinaryMemberscount($rightuser, $matrix_id);
                $leftcount             = $count['left'];
                $rightcount            = $count['right'];
                $lefttotalmember       = $leftcount;
                $righttotalmember      = $rightcount;
                $rightranktitle        = $rightranktitle == '' ? 'Nil' : $rightranktitle;
                $rightcrypturl = MURLCrypt::getEncryptURL($matrix_id, $rightuser);

                $output .= '<li class="float-left list-none relative pt-14 px-2 mt-0">
            <div class="border-solid border-neutral-300 border p-2 rounded-md inline-block">
                            <div class="!border-none py-1 px-2 inline-block" data-testid="person-container">
                                <span role="img" aria-label="Avatar for ish" title="Avatar for ish" class="bg-male inline-block relative h-10 w-10 cursor-pointer overflow-hidden rounded-full ">
                                    <a href="' .' /user' . '/network/view/' . $rightcrypturl . '"><img src="' . $rightmembers_image . '" alt=""  class="w-10 h-10 rounded-full overflow-hidden bg-white"></a>
                                </span>
                                <p class="m-0 text-black dark:text-white">' . $leftmembers_username . '</p>
                            </div>';
                if ($rightrank_icon_path != '') {
                    $output .= '<div class="rank"><img name="rankphoto" style="height: 40px;width:40px;" src="' . $rightrank_icon_path . '" class="w-10 h-10 rounded-full overflow-hidden bg-white" title="' . $rank . '"></div>';
                }
                $output .= '</div>';


                $output .= self::getDepthCompactGenealogy($rightuser, $matrix_id, $targetroot);

                $output .= '</li>';
            } else {

                $output .= self::getEmptyCompactGenealogytree($members_id, $matrix_id, '2');
            }

            $output .= ' </ul>
                    </li>
                </ul>
            </div>
            </div>';

            return $output;
        }
        public static function getDepthCompactGenealogy($members_id, $matrix_id, $targetroot)
        {
            $output = '<ul class="pt-14 relative flex flex-row items-baseline justify-center">';
            if ($members_id > 0) {


                $leftuser = MBinaryMembersPosition::getBinaryMembersPosition($members_id, $matrix_id, '1');
                $rightuser = MBinaryMembersPosition::getBinaryMembersPosition($members_id, $matrix_id, '2');

                if ($leftuser > 0) {

                    //showleftdetails
                    $binaryleftdetails         = MBinaryLinkDetails::getBinaryLinkDetails($leftuser, $matrix_id, $targetroot);
                    $leftdirect_id             = $binaryleftdetails['direct_id'];
                    $leftmatrix_doj            = $binaryleftdetails['matrix_doj'];
                    $leftmembers_username      = $binaryleftdetails['membername'];
                    $leftmembers_email         = $binaryleftdetails['members_email'];
                    $leftmembers_members_phone = $binaryleftdetails['members_phone'];
                    $leftmembers_image         = $binaryleftdetails['members_image'];
                    $leftranktitle             = $binaryleftdetails['ranktitle'];
                    $leftsponsor_username      = $binaryleftdetails['sponsor_username'];
                    $leftsponsor_username      = $leftdirect_id > '0' ? $leftsponsor_username : 'Nil';
                    $leftrankid                = $binaryleftdetails['rankid'];
                    $leftrank_icon_path        = $binaryleftdetails['rank_value'];
                    $leftmembers_image         = $leftmembers_image != '' ? $_ENV['CDNCLOUDEXTURL'] . '/' . $leftmembers_image : '' . $_ENV['UI_ASSET_URL'] . '/img/compact_emptyavatar.png';
                    if (empty($leftrank_icon_path)) {
                        $leftrank_icon_path = '';
                    } else {
                        $leftrank_icon_path = $_ENV['CDNCLOUDEXTURL'] . '/' . $leftrank_icon_path;
                    }

                    $leftcontacttemplate       = $leftrankid > '0' ? 'contactTemplate' : 'contactTemplate1';
                    $count                     = MBinaryMembersCount::getBinaryMemberscount($leftuser, $matrix_id);
                    $leftcount                 = $count['left'];
                    $rightcount                = $count['right'];
                    $lefttotalmember           = $leftcount;
                    $righttotalmember          = $rightcount;
                    $leftranktitle             = $leftranktitle == '' ? 'Nil' : $leftranktitle;
                    $leftcrypturl = MURLCrypt::getEncryptURL($matrix_id, $leftuser);

                    $output .= '<li class="float-left list-none relative pt-14 px-2 mt-0">
                                <div class="border-solid border-neutral-300 border p-2 rounded-md inline-block">
                                    <div class="!border-none py-1 px-2 inline-block" data-testid="person-container">
                                        <span role="img" aria-label="Avatar for satvy" title="Avatar for satvy" class="inline-block relative h-10 w-10 cursor-pointer overflow-hidden rounded-full ">
                                             <a href="' . '/user' . '/network/view/' . $leftcrypturl . '"><img src="' . $leftmembers_image . '" alt="" class="w-10 h-10 rounded-full overflow-hidden bg-white" ></a>
                                        </span>
                                        <p class="m-0 text-black dark:text-white">' . $leftmembers_username . ' </p>
                                    </div>';
                    if ($leftrank_icon_path != '') {
                        $output .= '<div class="rank"><img name="rankphoto" style="height: 40px;width:40px;" src="' . $leftrank_icon_path . '" class="w-10 h-10 rounded-full overflow-hidden bg-white" title="' . $leftranktitle . '"></div>';
                    }
                    $output .= '</div>
                            </li>';
                } else {

                    $output .= self::getEmptyCompactGenealogytree($members_id, $matrix_id, '1');
                }
                if ($rightuser > 0) {

                    //showrightdetails
                    $binaryrightdetails    = MBinaryLinkDetails::getBinaryLinkDetails($rightuser, $matrix_id, $targetroot);
                    $rightdirect_id        = $binaryrightdetails['direct_id'];
                    $rightmatrix_doj       = $binaryrightdetails['matrix_doj'];
                    $rightmembers_username = $binaryrightdetails['membername'];
                    $rightmembers_phone    = $binaryrightdetails['members_phone'];
                    $rightranktitle        = $binaryrightdetails['ranktitle'];
                    $rightmembers_email    = $binaryrightdetails['members_email'];
                    $rightmembers_image    = $binaryrightdetails['members_image'];
                    $rightsponsor_username = $binaryrightdetails['sponsor_username'];
                    $rightsponsor_username = $rightdirect_id > '0' ? $rightsponsor_username : 'Nil';
                    $rightrankid           = $binaryrightdetails['rankid'];
                    $rightrank_icon_path   = $binaryrightdetails['rank_value'];
                    $rightmembers_image    = $rightmembers_image != '' ? $_ENV['CDNCLOUDEXTURL'] . '/' . $rightmembers_image : '' . $_ENV['UI_ASSET_URL'] . '/img/compact_emptyavatar.png';
                    if (empty($rightrank_icon_path)) {
                        $rightrank_icon_path = '';
                    } else {
                        $rightrank_icon_path = $_ENV['CDNCLOUDEXTURL'] . '/' . $rightrank_icon_path;
                    }
                    $rightcontacttemplate  = $rightrankid > '0' ? 'contactTemplate' : 'contactTemplate1';
                    $count                 = MBinaryMembersCount::getBinaryMemberscount($rightuser, $matrix_id);
                    $leftcount             = $count['left'];
                    $rightcount            = $count['right'];
                    $lefttotalmember       = $leftcount;
                    $righttotalmember      = $rightcount;
                    $rightranktitle        = $rightranktitle == '' ? 'Nil' : $rightranktitle;
                    $rightcrypturl = MURLCrypt::getEncryptURL($matrix_id, $rightuser);

                    $output .= '<li class="float-left list-none relative pt-14 px-2 ">
                <div class="border-solid border-neutral-300 border p-2 rounded-md inline-block">
                    <div class="!border-none py-1 px-2 inline-block" data-testid="person-container">
                        <span role="img" aria-label="Avatar for satvy" title="Avatar for satvy" class="inline-block relative h-10 w-10 cursor-pointer overflow-hidden rounded-full ">
                             <a href="' . '/user' . '/network/view/' . $rightcrypturl . '"><img src="' . $rightmembers_image . '" alt="" class="w-10 h-10 rounded-full overflow-hidden bg-white" ></a>
                        </span>
                        <p class="m-0 text-black dark:text-white">' . $rightmembers_username . ' </p>
                    </div>';
                    if ($rightrank_icon_path != '') {
                        $output .= '<div class="rank"><img name="rankphoto" style="height: 40px;width:40px;" src="' . $rightrank_icon_path . '" class="w-10 h-10 rounded-full overflow-hidden bg-white" title="' . $rightranktitle . '"></div>';
                    }
                    $output .= '</div>
            </li>';
                } else {

                    $output .= self::getEmptyCompactGenealogytree($members_id, $matrix_id, '2');
                }
            }
            $output .= '</ul>';

            return $output;
        }
        public static function getEmptyCompactGenealogytree($members_id, $matrix_id, $position)
        {
            $emtpyimagepath = '' . $_ENV['UI_ASSET_URL'] . '/img/compact_emptyavatar.png';
            $output = '<li class="float-left list-none relative pt-14 px-2 ">
                                    <div class="border-solid border-neutral-300 border p-2 rounded-md inline-block">
                                        <div class="!border-none py-1 px-2 inline-block" data-testid="person-container">
                                            <span role="img" aria-label="Avatar for satvy" title="Avatar for satvy" class="bg-female inline-block relative h-10 w-10 cursor-pointer overflow-hidden rounded-full ">
                                                 <img src="' . $emtpyimagepath . '" alt="" class="w-10 h-10 rounded-full overflow-hidden bg-white">
                                            </span>
                                            <p class="m-0 text-black dark:text-white">empty </p>
                                        </div>
                                    </div>
                                </li>';
            return $output;
        }
    }
    ?>
