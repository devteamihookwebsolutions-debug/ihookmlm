<?php
namespace Admin\App\Models\Genealogy;

use Admin\App\Models\Middleware\MBinaryMembersPosition;
use Admin\App\Models\Middleware\MURLCrypt;
use Admin\App\Models\Member\Matrix;
use Admin\App\Models\Member\MatrixConfiguration;
use Admin\App\Models\Member\MemberLinks;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Admin\App\Models\Genealogy\MBinaryLinkDetails;
use Admin\App\Models\Genealogy\MBinaryMembersCount;
use Admin\App\Models\Genealogy\MMembersCount;
use Admin\App\Models\Middleware\MMatrixMemberLink;

class MBinaryGenealogy
{
    public static function getBinaryGenealogyDetails($members_id,$matrix_id)
    {
        $output = '';
        $binaryparentdetails   = MBinaryLinkDetails::getBinaryLinkDetails($members_id, $matrix_id);
        // dd($binaryparentdetails);
        $direct_id             = $binaryparentdetails['direct_id']??'';
        $matrix_doj            = $binaryparentdetails['matrix_doj']??'';
        $spillover_id          = $binaryparentdetails['spillover_id']??'';
        $members_username      = $binaryparentdetails['membername']??'';
        $members_phone         = $binaryparentdetails['members_phone']??'';
        $members_email         = $binaryparentdetails['members_email']??'';
        // $members_image         = $binaryparentdetails['members_image'];
   $memberImagePath = $binaryparentdetails['members_image'] ?? 'uploads/members/avatar.png';

        $memberImage     = asset($memberImagePath)??'';
        $parentroot            = $binaryparentdetails['root']??'';
        $ranktitle             = $binaryparentdetails['ranktitle']??'';
        $sponsor_username      = $binaryparentdetails['sponsor_username']??'';
        $sponsor_username      = $direct_id > '0' ? $sponsor_username : 'Nil';
        $rankid                = $binaryparentdetails['rankid']??'';
        $rankIconPath    = $binaryparentdetails['rank_icon_path'] ?? '';

        $leftuser=MBinaryMembersPosition::getBinaryMembersPosition($members_id,$matrix_id,'1');
        $rightuser=MBinaryMembersPosition::getBinaryMembersPosition($members_id,$matrix_id,'2');

        $rank_icon_path        = $rankid == '' ? '0' : $rankIconPath;
       $targetroot = (int)$parentroot + 3;

        $parentcontacttemplate = $rankid > '0' ? 'contactTemplate' : 'contactTemplate1';
        // $memberimage           = $members_image != '' ?  $members_image : 'uploads/avatar/emptyavatar.png';
		// $memberimage = $_ENV['CDNCLOUDEXTURL'].'/'.$members_image;
        // $rankIconPath        = $rankIconPath == '' ? '' :  $rankIconPath;
		// $rankIconPath = $_ENV['CDNCLOUDEXTURL'].'/'.$rankIconPath;
        $count                 = MBinaryMembersCount::getBinaryMemberscount($members_id, $matrix_id);
        $leftcount             = $count['left'];
        $rightcount            = $count['right'];
        $lefttotalmember       = $leftcount;
        $righttotalmember      = $rightcount;
        $rank                  = $ranktitle == '' ? 'Nil' : $ranktitle;
        $output .= '{ id:  "' . $members_id . '", parent: "' . $spillover_id . '", title: "' . $members_username . '", description: "Sponsor : ' . $sponsor_username . '", phone: "' . $members_phone . '", email: "' . $members_email . '",rank: "Rank : ' . $rank . '", image: "' . $memberImage . '", rankimage: "' . $rankIconPath . '",  templateName: "' . $parentcontacttemplate . '",leftmembercount:"Left total members : ' . $lefttotalmember . '",rightmembercount:"Right total members : ' . $righttotalmember . '", members_id: "' . $members_id . '", href: "/genealogy/viewtree/' . $members_id . '"},';

        // $where                = 'spillover_id="' . $members_id . '" AND matrix_id="' . $matrix_id . '" AND position>0 ORDER BY link_id ASC ';
        // $referralslinkdetails = MMatrixMemberLink::getMatrixLinkDetails($where);
        $where = [
            ['spillover_id', '=', $members_id],
            ['matrix_id', '=', $matrix_id],
            ['position', '>', 0],
        ];

        $referralslinkdetails = MemberLinks::where($where)
            ->orderBy('link_id', 'ASC')
            ->get();

        if (count((array)$referralslinkdetails) == '2') { //for both side  is filled
            //showleftdetails
            // dd('asdkf');
            $binaryleftdetails         = MBinaryLinkDetails::getBinaryLinkDetails($leftuser, $matrix_id, $targetroot);
            $leftdirect_id             = $binaryleftdetails['direct_id']??'';
            $leftmatrix_doj            = $binaryleftdetails['matrix_doj']??'';
            $leftmembers_username      = $binaryleftdetails['membername']??'';
            $leftmembers_email         = $binaryleftdetails['members_email']??'';
            $leftmembers_members_phone = $binaryleftdetails['members_phone']??'';
            $leftmembers_image         = $binaryleftdetails['members_image']??'';
            $leftranktitle             = $binaryleftdetails['ranktitle']??'';
            $leftsponsor_username      = $binaryleftdetails['sponsor_username']??'';
            $leftsponsor_username      = $leftdirect_id > '0' ? $leftsponsor_username : 'Nil'??'';
            $leftrankid                = $binaryleftdetails['rankid']??'';
            $leftrank_icon_path        = $binaryleftdetails['rank_icon_path']??'';

    $leftmembers_imagePath = $binaryparentdetails['members_image'] ?? 'uploads/members/avatar.png';

           $leftmembers_image     = asset($leftmembers_imagePath);
            // $leftmembers_image         = $leftmembers_image != '' ?  $leftmembers_image : 'uploads/avatar/emptyavatar.png';
			$leftrank_icon_path        = $leftrank_icon_path == '' ?  :  $leftrank_icon_path;
			// $leftmembers_image = $_ENV['CDNCLOUDEXTURL'].'/'.$leftmembers_image;
			// $leftrank_icon_path = $_ENV['CDNCLOUDEXTURL'].'/'.$leftrank_icon_path;
            $leftcontacttemplate       = $leftrankid > '0' ? 'contactTemplate' : 'contactTemplate1';
            $count                     = MBinaryMembersCount::getBinaryMemberscount($leftuser, $matrix_id);
            $leftcount                 = $count['left'];
            $rightcount                = $count['right'];
            $lefttotalmember           = $leftcount;
            $righttotalmember          = $rightcount;
            $leftranktitle             = $leftranktitle == '' ? 'Nil' : $leftranktitle;
            if ($leftuser > 0) {
                $output .= '{ id:  "' . $leftuser . '", parent: "' . $members_id . '", title: "' . $leftmembers_username . '", description: "Sponsor : ' . $leftsponsor_username . '", phone: "' . $leftmembers_members_phone . '", email: "' . $leftmembers_email . '",rank: "Rank : ' . $leftranktitle . '", image: "' . $leftmembers_image . '", rankimage: "' . $leftrank_icon_path . '",leftmembercount:"Left total members : ' . $lefttotalmember . '",rightmembercount:"Right total members : ' . $righttotalmember . '", templateName: "' . $leftcontacttemplate . '", members_id: "' . $leftuser . '",href: "/genealogy/viewtree/' . $leftuser . '"},';
                $output .= self::getDepthBinaryGenealogy($leftuser, $matrix_id, $targetroot);
            }
            //showrightdetails
            $binaryrightdetails    = MBinaryLinkDetails::getBinaryLinkDetails($rightuser, $matrix_id, $targetroot);
            $rightdirect_id        = $binaryrightdetails['direct_id']??'';
            $rightmatrix_doj       = $binaryrightdetails['matrix_doj']??'';
            $rightmembers_username = $binaryrightdetails['membername']??'';
            $rightmembers_phone    = $binaryrightdetails['members_phone']??'';
            $rightranktitle        = $binaryrightdetails['ranktitle']??'';
            $rightmembers_email    = $binaryrightdetails['members_email']??'';
            $rightmembers_image    = $binaryrightdetails['members_image']??'';
            $rightsponsor_username = $binaryrightdetails['sponsor_username']??'';
            $rightsponsor_username = $rightdirect_id > '0' ? $rightsponsor_username : 'Nil'??'';
            $rightrankid           = $binaryrightdetails['rankid']??'';
            $rightrank_icon_path   = $binaryrightdetails['rank_icon_path']??'';
            // $rightmembers_image    = $rightmembers_image != '' ?  $rightmembers_image : 'uploads/avatar/emptyavatar.png';

     $rightmembers_imagePath = $binaryparentdetails['members_image'] ?? 'uploads/members/avatar.png';

           $rightmembers_image     = asset($rightmembers_imagePath);
            $rightrank_icon_path   = $rightrank_icon_path == '' ? '' : $rightrank_icon_path;
            $rightcontacttemplate  = $rightrankid > '0' ? 'contactTemplate' : 'contactTemplate1';
            $count                 = MBinaryMembersCount::getBinaryMemberscount($rightuser, $matrix_id);
            $leftcount             = $count['left'];
            $rightcount            = $count['right'];
            $lefttotalmember       = $leftcount;
            $righttotalmember      = $rightcount;
            $rightranktitle        = $rightranktitle == '' ? 'Nil' : $rightranktitle;
            if ($rightuser > 0) {
                $output .= '{ id:  "' . $rightuser . '", parent: "' . $members_id . '", title: "' . $rightmembers_username . '", description: "Sponsor : ' . $rightsponsor_username . '", phone: "' . $rightmembers_phone . '", email: "' . $rightmembers_email . '",rank: "Rank : ' . $rightranktitle . '", image: "' . $rightmembers_image . '", rankimage: "' . $rightrank_icon_path . '",leftmembercount:"Left total members : ' . $lefttotalmember . '",rightmembercount:"Right total members : ' . $righttotalmember . '",  templateName: "' . $rightcontacttemplate . '", members_id: "' . $rightuser . '", href: "/genealogy/viewtree/' . $rightuser . '"},';
                $output .= self::getDepthBinaryGenealogy($rightuser, $matrix_id, $targetroot);
            }
        }elseif (count((array)$referralslinkdetails) == '1') { //for one side  is filled
            if ($leftuser > 0) {
                //showleftdetails
                $binaryleftdetails         = MBinaryLinkDetails::getBinaryLinkDetails($leftuser, $matrix_id, $targetroot);
                $leftdirect_id             = $binaryleftdetails['direct_id'];
                $leftmatrix_doj            = $binaryleftdetails['matrix_doj'];
                $leftmembers_username      = $binaryleftdetails['membername'];
                $leftmembers_members_phone = $binaryleftdetails['members_phone'];
                $leftmembers_email         = $binaryleftdetails['members_email'];
                $leftranktitle             = $binaryleftdetails['ranktitle'];
                $leftmembers_image         = $binaryleftdetails['members_image'];
                $leftsponsor_username      = $binaryleftdetails['sponsor_username'];
                $leftsponsor_username      = $leftdirect_id > '0' ? $leftsponsor_username : 'Nil';
                $leftbirankid              = trim($binaryleftdetails['rankid']);
                $leftrank_icon_path        = $binaryleftdetails['rank_icon_path'];
                $leftcontacttemplate       = $leftbirankid > '0' ? 'contactTemplate' : 'contactTemplate1';
                // $leftmembers_image         = $leftmembers_image != '' ?  $leftmembers_image : 'uploads/avatar/emptyavatar.png';
                 
            $leftmembers_imagePath = $binaryparentdetails['members_image'] ?: 'uploads/members/avatar.png';
           $leftmembers_image     = asset($leftmembers_imagePath);
                $leftrank_icon_path        = $leftrank_icon_path == '' ? '' : $leftrank_icon_path;
				
				// $leftmembers_image = $_ENV['CDNCLOUDEXTURL'].'/'.$leftmembers_image;
				// $leftrank_icon_path = $_ENV['CDNCLOUDEXTURL'].'/'.$leftrank_icon_path;
				
                $count                     = MBinaryMembersCount::getBinaryMemberscount($leftuser, $matrix_id);
                $leftcount                 = $count['left'];
                $rightcount                = $count['right'];
                $lefttotalmember           = $leftcount;
                $righttotalmember          = $rightcount;
                $leftranktitle             = $leftranktitle == '' ? 'Nil' : $leftranktitle;
                $output .= '{ id:  "' . $leftuser . '", parent: "' . $members_id . '", title: "' . $leftmembers_username . '", description: "Sponsor : ' . $leftsponsor_username . '", phone: "' . $leftmembers_members_phone . '", email: "' . $leftmembers_email . '", image: "' . $leftmembers_image . '",rank: "Rank : ' . $leftranktitle . '",rankimage: "' . $leftrank_icon_path . '",leftmembercount:"Left total members : ' . $lefttotalmember . '",rightmembercount:"Right total members : ' . $righttotalmember . '",  templateName: "' . $leftcontacttemplate . '", members_id: "' . $members_id . '",href: "/genealogy/viewtree/' . $leftuser . '"},';
                $position = '2';
                // $output .= self::getEmptyBianryGenealogyDetails($members_id, $matrix_id, $position);
                $output .= self::getDepthBinaryGenealogy($leftuser, $matrix_id, $targetroot);
            }
            if ($rightuser > 0) {
                $position = '1';
                // $output .= self::getEmptyBianryGenealogyDetails($members_id, $matrix_id, $position);
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
                $rightrank_icon_path   = $binaryrightdetails['rank_icon_path'];

                // $rightmembers_image    = $rightmembers_image != '' ?  $rightmembers_image : 'uploads/avatar/emptyavatar.png';
                     $rightmembers_imagePath = $binaryparentdetails['members_image'] ?: 'uploads/avatar/emptyavatar.png';
           $rightmembers_image     = asset($rightmembers_imagePath);
                $rightrank_icon_path   = $rightrank_icon_path == '' ? '' :  $rightrank_icon_path;
				
				// $rightmembers_image = $_ENV['CDNCLOUDEXTURL'].'/'.$rightmembers_image;
				// $rightrank_icon_path = $_ENV['CDNCLOUDEXTURL'].'/'.$rightrank_icon_path;
				
                $rightcontacttemplate  = $rightrankid > '0' ? 'contactTemplate' : 'contactTemplate1';
                $count                 = MBinaryMembersCount::getBinaryMemberscount($rightuser, $matrix_id);
                $leftcount             = $count['left'];
                $rightcount            = $count['right'];
                $lefttotalmember       = $leftcount;
                $righttotalmember      = $rightcount;
                $rightranktitle        = $rightranktitle == '' ? 'Nil' : $rightranktitle;
                $output .= '{ id:  "' . $rightuser . '", parent: "' . $members_id . '", title: "' . $rightmembers_username . '", description: "Sponsor : ' . $rightsponsor_username . '", phone: "' . $rightmembers_phone . '", email: "' . $rightmembers_email . '",image: "' . $rightmembers_image . '",rank: "Rank : ' . $rightranktitle . '", rankimage: "' . $rightrank_icon_path . '",leftmembercount:"Left total members : ' . $lefttotalmember . '",rightmembercount:"Right total members : ' . $righttotalmember . '",templateName: "' . $rightcontacttemplate . '", members_id: "' . $members_id . '", href: "/genealogy/viewtree/' . $rightuser . '"},';
                $output .= self::getDepthBinaryGenealogy($rightuser, $matrix_id, $targetroot);
            }
        }elseif (count((array)$referralslinkdetails) == '0') { //for both side  is empty
            // $output .= self::getEmptyBianryGenealogyDetails($members_id, $matrix_id, '1');
            // $output .= self::getEmptyBianryGenealogyDetails($members_id, $matrix_id, '2');
        }



        $output    = 'var data=[' . $output . ']';
        
        // dd($output);
        return  $output;
    }


        public static function getDepthBinaryGenealogy($members_id, $matrix_id, $targetroot)
    {
        $output = '';
        if ($members_id > 0) {
            $groupTitleColor       = '#4169e1';
            $itemTitleColor        = '#B800E6';
            $binaryparentdetails   = MBinaryLinkDetails::getBinaryLinkDetails($members_id, $matrix_id, $targetroot);
            $direct_id             = $binaryparentdetails['direct_id'];
            $matrix_doj            = $binaryparentdetails['matrix_doj'];
            $members_username      = $binaryparentdetails['membername'];
            $members_email         = $binaryparentdetails['members_email'];
            $members_image         = $binaryparentdetails['members_image'];
            $childroot             = $binaryparentdetails['root'];
            $sponsor_username      = $binaryparentdetails['sponsor_username'];
            $sponsor_username      = $direct_id > '0' ? $sponsor_username : 'Nil';
            $rankid                = $binaryparentdetails['rankid'];
            $rankIconPath        = $binaryparentdetails['rank_icon_path'];

        
            $leftuser=MBinaryMembersPosition::getBinaryMembersPosition($members_id,$matrix_id,'1');
            $rightuser=MBinaryMembersPosition::getBinaryMembersPosition($members_id,$matrix_id,'2');

            $rank_icon_path        = $rankid == '' ? '0' : $rank_icon_path;
            // $where                 = 'spillover_id="' . $members_id . '" AND matrix_id="' . $matrix_id . '" AND position>0 ORDER BY link_id ASC ';
            // $referralslinkdetails  = MMatrixMemberLink::getMatrixLinkDetails($where);
             $where = [
            ['spillover_id', '=', $members_id],
            ['matrix_id', '=', $matrix_id],
            ['position', '>', 0],
        ];

        $referralslinkdetails = MemberLinks::where($where)
            ->orderBy('link_id', 'ASC')
            ->get();
        if ($childroot <= $targetroot) {
    if (count((array)$referralslinkdetails) == '2') { // for both sides filled
            // dd('function reached');
        // ---- LEFT USER ----
        $binaryleftdetails = MBinaryLinkDetails::getBinaryLinkDetails($leftuser, $matrix_id, $targetroot);
        //  dd($binaryleftdetails);
        if (!is_array($binaryleftdetails) || empty($binaryleftdetails)) {
            // If no data found, create empty placeholder node
            // $output .= self::getEmptyBianryGenealogyDetails($members_id, $matrix_id, '1');
        } else {
            $leftdirect_id        = $binaryleftdetails['direct_id'] ?? 0;
            $leftmatrix_doj       = $binaryleftdetails['matrix_doj'] ?? '';
            $leftmembers_username = $binaryleftdetails['membername'] ?? '';
            $leftmembers_email    = $binaryleftdetails['members_email'] ?? '';
            $leftranktitle        = $binaryleftdetails['ranktitle'] ?? '';
            $leftmembers_phone    = $binaryleftdetails['members_phone'] ?? '';

            // $leftmembers_image    = $binaryleftdetails['members_image'] ?? 'uploads/avatar/emptyavatar.png';
          $memberImagePath = $binaryparentdetails['members_image'] ?: 'uploads/avatar/emptyavatar.png';
          $leftmembers_image     = asset($memberImagePath);

            $leftsponsor_username = $binaryleftdetails['sponsor_username'] ?? 'Nil';
            $leftrankid           = $binaryleftdetails['rankid'] ?? 0;
            $leftrank_icon_path   = $binaryleftdetails['rank_icon_path'] ?? '';

            $leftcontacttemplate  = $leftrankid > 0 ? 'contactTemplate' : 'contactTemplate1';
            $count                = MBinaryMembersCount::getBinaryMemberscount($leftuser, $matrix_id);
            $lefttotalmember      = $count['left'] ?? 0;
            $righttotalmember     = $count['right'] ?? 0;
            $leftranktitle        = $leftranktitle == '' ? 'Nil' : $leftranktitle;

            $output .= '{ 
                id:  "' . $leftuser . '", 
                parent: "' . $members_id . '", 
                title: "' . $leftmembers_username . '", 
                description: "Sponsor : ' . $leftsponsor_username . '", 
                phone: "' . $leftmembers_phone . '", 
                email: "' . $leftmembers_email . '",
                rank: "Rank : ' . $leftranktitle . '", 
                image: "' . $leftmembers_image . '", 
                rankimage: "' . $leftrank_icon_path . '",
                leftmembercount:"Left total members : ' . $lefttotalmember . '",
                rightmembercount:"Right total members : ' . $righttotalmember . '",  
                templateName: "' . $leftcontacttemplate . '", 
                members_id: "' . $leftuser . '",
                href: "/genealogy/viewtree/' . $leftuser . '"
            },';

            $output .= self::getDepthBinaryGenealogy($leftuser, $matrix_id, $targetroot);
        }

        // ---- RIGHT USER ----
        $binaryrightdetails = MBinaryLinkDetails::getBinaryLinkDetails($rightuser, $matrix_id, $targetroot);

        if (!is_array($binaryrightdetails) || empty($binaryrightdetails)) {
            // $output .= self::getEmptyBianryGenealogyDetails($members_id, $matrix_id, '2');
        } else {
            $rightdirect_id        = $binaryrightdetails['direct_id'] ?? 0;
            $rightmatrix_doj       = $binaryrightdetails['matrix_doj'] ?? '';
            $rightmembers_username = $binaryrightdetails['membername'] ?? '';
            $rightmembers_email    = $binaryrightdetails['members_email'] ?? '';
            $rightranktitle        = $binaryrightdetails['ranktitle'] ?? '';
            $rightmembers_phone    = $binaryrightdetails['members_phone'] ?? '';

            // $rightmembers_image    = $binaryrightdetails['members_image'] ?? 'uploads/avatar/emptyavatar.png';
          $memberImagePath = $binaryparentdetails['members_image'] ?: 'uploads/avatar/emptyavatar.png';
          $rightmembers_image     = asset($memberImagePath);
            $rightsponsor_username = $binaryrightdetails['sponsor_username'] ?? 'Nil';
            $rightrankid           = $binaryrightdetails['rankid'] ?? 0;
            $rightrank_icon_path   = $binaryrightdetails['rank_icon_path'] ?? '';

            $rightcontacttemplate  = $rightrankid > 0 ? 'contactTemplate' : 'contactTemplate1';
            $count                 = MBinaryMembersCount::getBinaryMemberscount($rightuser, $matrix_id);
            $lefttotalmember       = $count['left'] ?? 0;
            $righttotalmember      = $count['right'] ?? 0;
            $rightranktitle        = $rightranktitle == '' ? 'Nil' : $rightranktitle;

            $output .= '{ 
                id:  "' . $rightuser . '", 
                parent: "' . $members_id . '", 
                title: "' . $rightmembers_username . '", 
                description: "Sponsor : ' . $rightsponsor_username . '", 
                phone: "' . $rightmembers_phone . '", 
                email: "' . $rightmembers_email . '",
                rank: "Rank : ' . $rightranktitle . '", 
                image: "' . $rightmembers_image . '", 
                rankimage: "' . $rightrank_icon_path . '",
                leftmembercount:"Left total members : ' . $lefttotalmember . '",
                rightmembercount:"Right total members : ' . $righttotalmember . '",  
                templateName: "' . $rightcontacttemplate . '", 
                members_id: "' . $members_id . '",
                href: "/genealogy/viewtree/' . $rightuser . '"
            },';

            $output .= self::getDepthBinaryGenealogy($rightuser, $matrix_id, $targetroot);
        }

    } elseif (count((array)$referralslinkdetails) == '1') {
        // handle 1-child case (same null-safe checks apply)
        // reuse same logic blocks for left/right individually as above
    } elseif (count((array)$referralslinkdetails) == '0' && $childroot < $targetroot) {
        // $output .= self::getEmptyBianryGenealogyDetails($members_id, $matrix_id, '1');
        // $output .= self::getEmptyBianryGenealogyDetails($members_id, $matrix_id, '2');
    }
}

        }
        // dd($output);
        return $output;
    }
    public static function getEmptyBianryGenealogyDetails($members_id, $matrix_id, $position)
    {
        $output         = '';
		// $emtpyimagepath = $_ENV['UI_ASSET_URL'].'/public/assets/img/no-avatar.png';
        	$emtpyimagepath = asset('uploads/avatar/emptyavatar.png');

        $randommember   = mt_rand(10000000, 99999999);
        $output .= '{ id:  "' . $randommember . '", parent: "' . $members_id . '",position:"' . $position . '", title: "",image: "' . $emtpyimagepath . '",templateName: "contactTemplate2", href: "/genealogy/viewtree/' . $members_id . '"},';

       
        // dd($output);
        return $output;
    }



//   public static function getBinaryGenealogyDetails($members_id, $matrix_id)
//     {
//         $output = '';
//         $binaryparentdetails = MBinaryLinkDetails::getBinaryLinkDetails($members_id, $matrix_id);

//         $members_username = $binaryparentdetails['membername'] ?? '';
//         $members_phone    = $binaryparentdetails['members_phone'] ?? '';
//         $members_email    = $binaryparentdetails['members_email'] ?? '';
//         $memberImagePath  = $binaryparentdetails['members_image'] ?: 'uploads/members/avatar.png';
//         $memberImage      = asset($memberImagePath);
//         $ranktitle        = $binaryparentdetails['ranktitle'] ?: 'Nil';
//         $rankIconPath     = $binaryparentdetails['rank_icon_path'] ?? '';
//         $spillover_id     = $binaryparentdetails['spillover_id'] ?? '';
//         $rankid           = $binaryparentdetails['rankid'] ?? 0;
//         $parentcontacttemplate = $rankid > 0 ? 'contactTemplate' : 'contactTemplate1';

//         $count = MBinaryMembersCount::getBinaryMemberscount($members_id, $matrix_id);
//         $lefttotalmember  = $count['left'] ?? 0;
//         $righttotalmember = $count['right'] ?? 0;

//         $output .= '{ 
//             id:  "' . $members_id . '", 
//             parent: "' . $spillover_id . '", 
//             title: "' . $members_username . '", 
//             description: "Sponsor : ' . ($binaryparentdetails['sponsor_username'] ?? 'Nil') . '", 
//             phone: "' . $members_phone . '", 
//             email: "' . $members_email . '", 
//             rank: "Rank : ' . $ranktitle . '", 
//             image: "' . $memberImage . '", 
//             rankimage: "' . $rankIconPath . '", 
//             leftmembercount:"Left total members : ' . $lefttotalmember . '", 
//             rightmembercount:"Right total members : ' . $righttotalmember . '",  
//             templateName: "' . $parentcontacttemplate . '", 
//             members_id: "' . $members_id . '", 
//             href: "/genealogy/viewtree/' . $members_id . '" 
//         },';

//         // Process children recursively
//         $output .= self::getDepthBinaryGenealogy($members_id, $matrix_id);

//         $output = 'var data=[' . $output . ']';
//         // dd($output);
//         return $output;
//     }

//     public static function getDepthBinaryGenealogy($members_id, $matrix_id)
//     {
//         $output = '';
//         if ($members_id <= 0) return $output;

//         $leftuser  = MBinaryMembersPosition::getBinaryMembersPosition($members_id, $matrix_id, '1');
//         $rightuser = MBinaryMembersPosition::getBinaryMembersPosition($members_id, $matrix_id, '2');

//         $children = [$leftuser, $rightuser];

//         foreach ($children as $position => $child_id) {
//             if ($child_id > 0) {
//                 $binarydetails = MBinaryLinkDetails::getBinaryLinkDetails($child_id, $matrix_id);
//                 if (!is_array($binarydetails) || empty($binarydetails)) continue;

//                 $members_username = $binarydetails['membername'] ?? '';
//                 $members_phone    = $binarydetails['members_phone'] ?? '';
//                 $members_email    = $binarydetails['members_email'] ?? '';
//                 $memberImagePath  = $binarydetails['members_image'] ?: 'uploads/members/avatar.png';
//                 $memberImage      = asset($memberImagePath);
//                 $ranktitle        = $binarydetails['ranktitle'] ?: 'Nil';
//                 $rankIconPath     = $binarydetails['rank_icon_path'] ?? '';
//                 $rankid           = $binarydetails['rankid'] ?? 0;
//                 $contacttemplate  = $rankid > 0 ? 'contactTemplate' : 'contactTemplate1';
//                 $spillover_id     = $binarydetails['spillover_id'] ?? '';

//                 $count = MBinaryMembersCount::getBinaryMemberscount($child_id, $matrix_id);
//                 $lefttotalmember  = $count['left'] ?? 0;
//                 $righttotalmember = $count['right'] ?? 0;

//                 $output .= '{ 
//                     id:  "' . $child_id . '", 
//                     parent: "' . $members_id . '", 
//                     title: "' . $members_username . '", 
//                     description: "Sponsor : ' . ($binarydetails['sponsor_username'] ?? 'Nil') . '", 
//                     phone: "' . $members_phone . '", 
//                     email: "' . $members_email . '", 
//                     rank: "Rank : ' . $ranktitle . '", 
//                     image: "' . $memberImage . '", 
//                     rankimage: "' . $rankIconPath . '", 
//                     leftmembercount:"Left total members : ' . $lefttotalmember . '", 
//                     rightmembercount:"Right total members : ' . $righttotalmember . '",  
//                     templateName: "' . $contacttemplate . '", 
//                     members_id: "' . $child_id . '", 
//                     href: "/genealogy/viewtree/' . $child_id . '" 
//                 },';

//                 // Recursive call
//                 // dd($output);
//                 $output .= self::getDepthBinaryGenealogy($child_id, $matrix_id);
//             }
//         }

//         return $output;
//     }

}