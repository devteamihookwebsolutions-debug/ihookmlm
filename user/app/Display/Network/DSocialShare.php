<?php
/**
 * This class contains public static functions related to user network
 *
 * @package         DSocialShare
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

class DSocialShare
{
    /**
     * This public static function is used to show in active network details of member
     * @param string  $encode_description
     * @param string  $socailurl
     * @return HTML data
     */
    public static function getSocialShare($encode_description, $socailurl)
    {
        $res = '<a aria-label="link" class ="fb" href="https://www.facebook.com/sharer/sharer.php?quote=' . $encode_description . '&amp;u=' . $socailurl . '" target="_blank" rel="noopener"  tabindex="1" class="at-icon-wrapper at-share-btn at-svc-facebook" style="background-color: #3b5998;; border-radius: 2px;"><span class="at4-visually-hidden"><i class="flaticon-facebook"></i></span><span class="at-icon-wrapper" style="line-height: 16px; height: 16px; width: 16px;"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" version="1.1" role="img" aria-labelledby="at-svg-facebook-1" style="fill: rgb(255, 255, 255); width: 16px; height: 16px;" class="at-icon at-icon-facebook"><title id="at-svg-facebook-1">Facebook</title><g><path d="M22 5.16c-.406-.054-1.806-.16-3.43-.16-3.4 0-5.733 1.825-5.733 5.17v2.882H9v3.913h3.837V27h4.604V16.965h3.823l.587-3.913h-4.41v-2.5c0-1.123.347-1.903 2.198-1.903H22V5.16z" fill-rule="evenodd"></path></g></svg></span></a> 
                    
        <a aria-label="link" class = "tweet" href="https://twitter.com/intent/tweet?text=' . $encode_description . '" target="_blank" rel="noopener"  tabindex="1" class="at-icon-wrapper at-share-btn at-svc-twitter" style="background-color: #55acee; border-radius: 2px;"><span class="at4-visually-hidden"><i class="flaticon-twitter"></i></span><span class="at-icon-wrapper" style="line-height: 16px; height: 16px; width: 16px;"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" version="1.1" role="img" aria-labelledby="at-svg-twitter-2" style="fill: rgb(255, 255, 255); width: 16px; height: 16px;" class="at-icon at-icon-twitter"><title id="at-svg-twitter-2">Twitter</title><g><path d="M27.996 10.116c-.81.36-1.68.602-2.592.71a4.526 4.526 0 0 0 1.984-2.496 9.037 9.037 0 0 1-2.866 1.095 4.513 4.513 0 0 0-7.69 4.116 12.81 12.81 0 0 1-9.3-4.715 4.49 4.49 0 0 0-.612 2.27 4.51 4.51 0 0 0 2.008 3.755 4.495 4.495 0 0 1-2.044-.564v.057a4.515 4.515 0 0 0 3.62 4.425 4.52 4.52 0 0 1-2.04.077 4.517 4.517 0 0 0 4.217 3.134 9.055 9.055 0 0 1-5.604 1.93A9.18 9.18 0 0 1 6 23.85a12.773 12.773 0 0 0 6.918 2.027c8.3 0 12.84-6.876 12.84-12.84 0-.195-.005-.39-.014-.583a9.172 9.172 0 0 0 2.252-2.336" fill-rule="evenodd"></path></g></svg></span></a>         
        <a aria-label="link" class = "tweet" href="https://web.whatsapp.com/send?text=' . $encode_description . '" target="_blank" rel="noopener"  tabindex="1" class="at-icon-wrapper at-share-btn at-svc-twitter" style="background-color: #43d854; border-radius: 2px;"><span class="at4-visually-hidden"><svg class="w-6 h-6 text-black dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
  <path fill="currentColor" fill-rule="evenodd" d="M12 4a8 8 0 0 0-6.895 12.06l.569.718-.697 2.359 2.32-.648.379.243A8 8 0 1 0 12 4ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10a9.96 9.96 0 0 1-5.016-1.347l-4.948 1.382 1.426-4.829-.006-.007-.033-.055A9.958 9.958 0 0 1 2 12Z" clip-rule="evenodd"/>
  <path fill="currentColor" d="M16.735 13.492c-.038-.018-1.497-.736-1.756-.83a1.008 1.008 0 0 0-.34-.075c-.196 0-.362.098-.49.291-.146.217-.587.732-.723.886-.018.02-.042.045-.057.045-.013 0-.239-.093-.307-.123-1.564-.68-2.751-2.313-2.914-2.589-.023-.04-.024-.057-.024-.057.005-.021.058-.074.085-.101.08-.079.166-.182.249-.283l.117-.14c.121-.14.175-.25.237-.375l.033-.066a.68.68 0 0 0-.02-.64c-.034-.069-.65-1.555-.715-1.711-.158-.377-.366-.552-.655-.552-.027 0 0 0-.112.005-.137.005-.883.104-1.213.311-.35.22-.94.924-.94 2.16 0 1.112.705 2.162 1.008 2.561l.041.06c1.161 1.695 2.608 2.951 4.074 3.537 1.412.564 2.081.63 2.461.63.16 0 .288-.013.4-.024l.072-.007c.488-.043 1.56-.599 1.804-1.276.192-.534.243-1.117.115-1.329-.088-.144-.239-.216-.43-.308Z"/>
</svg></span><span class="at-icon-wrapper whatsapppp" style="line-height: 16px; height: 16px; width: 16px;"><svg version="1.1"  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
         viewBox="0 0 16 16" style="enable-background:new 0 0 16 16;" xml:space="preserve">
    <style type="text/css">
        .st0{fill:#43d854}
        .st1{fill:#FFFFFF;}
    </style>
    <path class="st0" d="M14.6,16H1.4C0.6,16,0,15.3,0,14.6V1.4C0,0.6,0.6,0,1.4,0h13.2C15.3,0,16,0.6,16,1.4v13.2
        C16,15.3,15.3,16,14.6,16z"/>
    <g>
        <g transform="translate(0.000000,462.000000) scale(0.100000,-0.100000)">
            <path class="st1" d="M74.7,4588.6c-20.9-2.8-37.2-18-41.1-38.4c-2-10.2-0.5-20.6,4.3-30.3l1.7-3.4l-4.3-12.6
                c-2.4-6.9-4.2-12.6-4.2-12.7c0,0,6,1.8,13.2,4.1l13.1,4.2l2.5-1.2c10.3-4.8,21.7-6,32.5-3.3c16.6,4.1,30,17.1,34.7,33.5
                c1.9,6.9,2.3,15.2,0.8,22.2c-3.3,16.1-14.8,29.6-30.4,35.4c-2.4,0.9-6.2,1.9-9.1,2.4C85.7,4588.9,77.6,4589,74.7,4588.6z
                 M86.6,4580.9c15.7-2.1,29-13.8,33.2-29.1c1.8-6.5,1.9-13.8,0.2-20.3c-3.4-13.2-13.4-24-26.4-28.3c-11.1-3.7-23.5-2.4-33.3,3.5
                c-0.9,0.5-1.7,1-1.8,1c-0.1,0-3.6-1.1-7.7-2.4c-4.2-1.3-7.6-2.3-7.6-2.2c0,0.1,1.1,3.4,2.5,7.4l2.5,7.2l-1.1,1.7
                c-1.4,2.1-3.6,6.6-4.4,9c-6.5,18.8,2.1,39.6,20.1,48.7C70,4580.8,78.1,4582.1,86.6,4580.9z"/>
            <path class="st1" d="M62.8,4562.5c-1.7-0.8-4-4.1-4.8-6.8c-0.2-0.5-0.4-1.9-0.4-3.1c-0.1-2.7,0.4-5.1,1.8-8.1
                c1.1-2.3,3.6-6,6.1-9.1c4.4-5.5,9.7-9.9,14.8-12.4c4-1.9,10.1-3.9,12.7-4.2c3.6-0.4,9,2,10.8,4.8c1.2,1.8,1.9,6.2,1.1,6.9
                c-0.4,0.4-8.5,4.3-10.1,4.9c-0.6,0.2-1.2,0.3-1.5,0.2c-0.3-0.1-1.1-0.9-2.1-2.1c-2.3-2.9-3.4-4-4-4c-0.8,0-5,2-7.3,3.5
                c-3,2-6.8,5.8-8.8,8.9c-0.9,1.3-1.5,2.5-1.5,2.8c0,0.3,0.6,1.1,1.5,2.2c1.4,1.6,2.6,3.5,2.6,4.1c0,0.1-1,2.6-2.2,5.5
                c-1.4,3.4-2.4,5.4-2.7,5.8c-0.6,0.6-0.7,0.6-2.8,0.6C64.1,4563,63.5,4562.9,62.8,4562.5z"/>
        </g>
    </g>
    </svg></span></a>                                               
    <a aria-label="link" href="mailto:?Body=' . $encode_description . '"  tabindex="1" class="at-icon-wrapper at-share-btn at-svc-email emailshare" style="background-color: #ea4335; border-radius: 2px;"><span class="at4-visually-hidden"></span><span class="at-icon-wrapper" style="line-height: 16px; height: 16px; width: 16px;"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" version="1.1" role="img" aria-labelledby="at-svg-email-1" style="fill: rgb(255, 255, 255); width: 16px; height: 16px;" class="at-icon at-icon-email"><title id="at-svg-email-1">Email</title><g><g fill-rule="evenodd"></g><path d="M27 22.757c0 1.24-.988 2.243-2.19 2.243H7.19C5.98 25 5 23.994 5 22.757V13.67c0-.556.39-.773.855-.496l8.78 5.238c.782.467 1.95.467 2.73 0l8.78-5.238c.472-.28.855-.063.855.495v9.087z"></path><path d="M27 9.243C27 8.006 26.02 7 24.81 7H7.19C5.988 7 5 8.004 5 9.243v.465c0 .554.385 1.232.857 1.514l9.61 5.733c.267.16.8.16 1.067 0l9.61-5.733c.473-.283.856-.96.856-1.514v-.465z"></path></g></svg></span></a>';
        return $res;
    }
}
?>    