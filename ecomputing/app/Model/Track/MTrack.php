<?php


/**
 * This class contains public functions related to send pv
 *
 * @package         MSendpv
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.com
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@sunsoftny.com.
*****************************************************************************/
?><?php
namespace Model\Track;
use Query\Bin_Query;

class MTrack
{
    public static function trackTest()
    {

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Origin, Accept");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json");

        $trackdata = @file_get_contents('php://input');
        if ($trackdata!="") {
        $query = new Bin_Query();
        $sql = "INSERT INTO " . $_ENV['PROMLM_PREFIX'] . "tracktest(trackdata) VALUES('".$trackdata."')";
        $query->updateQuery($sql);
        }

        $trackrecord=json_decode($trackdata);
        // print_r($trackrecord);exit;

        $bannerId=$trackrecord->bannerId;
        $platform=$trackrecord->platform;
        $language=$trackrecord->language;
        $location=$trackrecord->location;
        $screenResolution=$trackrecord->screenResolution;
        $browser=$trackrecord->browser;
        $os=$trackrecord->os;
        $ip=$trackrecord->ip;

        if($platform!=""){

        $url="https://ipinfo.io/$ip/json";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        $trackrecord2=json_decode($response);

        $city=$trackrecord2->city;
        $region=$trackrecord2->region;
        $country=$trackrecord2->country;
        $postal=$trackrecord2->postal;
        $timezone=$trackrecord2->timezone;
        $loc=$trackrecord2->loc;

        $query = new Bin_Query();
        $sql2 = "INSERT INTO " . $_ENV['PROMLM_PREFIX'] . "tracking_record(banner_id,platform,language,location,screenResolution,browser,os_data
              ,ip_data,country,regionName,city,zip,timezone,lat_long,created_on) VALUES('".$bannerId."','".$platform."','".$language."','".$location."',
            '".$screenResolution."','".$browser."','".$os."','".$ip."','".$country."','".$region."','".$city."',
           '".$postal."','".$timezone."','".$loc."',NOW())";
        $query->updateQuery($sql2);

    }




    }
}
