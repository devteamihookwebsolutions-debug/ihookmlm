<?php
/**
 * This class contains public static functions related to format data.
 *
 * @package         MFormatDate
 * @category        Model
 * @author          Sunsofty Dev Team
 * @link            https://sunsoftny.com
 * @copyright       Copyright (c) 2020 - 2025, Sunsofty.
 * @version         Version 8.1
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@sunsoftny.com.
*****************************************************************************/
?><?php


namespace Admin\App\Models\Middleware;


class MCryptoGraphy{

    /**
     * This public static function is used to decrypt the data
     * @param string $data
     * @return string
     */
    public static function decryptionData($data)
    {

        // $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        // $urladmin = explode($_ENV['CURRENT_PATH'], $actual_link);
        // if (CURRENT_FOLDER!='main') {
        //     $filepath = '../' . $_ENV['CURRENT_UPATH'] . '/';
        // }
           require_once base_path('admin/app/Lib/SafeCrypto.php');
        $key = '86B3OoUfef8#%^S==}_;,/???GvNPgH.';
        $result = safeDecrypt($data, $key);
        // $result = cryprt($data,$key);

        // // Store cipher method
        // $ciphering = "BF-CBC";

        // // Use OpenSSl encryption method
        // $iv_length = openssl_cipher_iv_length($ciphering);
        // $options = 0;


        // $decryption_iv = random_bytes($iv_length);

        // // Store the decryption key
        // $decryption_key = openssl_digest(php_uname(), 'MD5', TRUE);

        // // Descrypt the string
        // $result = openssl_decrypt ($data, $ciphering,
        // $decryption_key, $options, $encryption_iv);

        // echo '<pre>';print_r($result);exit;

        return $result;
    }
     /**
     * This public static function is used to encrypt the data
     * @param string $data
     * @return string
     */
    public static function encryptionData($data)
    {

        $datacrypted = sodium_crypto_pwhash_str($data, SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE, SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE);

        return $datacrypted;
    }
     /**
     * This public static function is used to encrypt the data
     * @param string $data
     * @return string
     */
    public static function encryptionDataExt($data)
    {
        // $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        // $urladmin = explode(env['CURRENT_PATH'], $actual_link);
        // if (CURRENT_FOLDER!='main') {
        //     $filepath = '../' . $_ENV['CURRENT_UPATH'] . '/';
        // }

    require_once base_path('admin/app/Lib/SafeCrypto.php');
        $key = '86B3OoUfef8#%^S==}_;,/???GvNPgH.';
        $result = safeEncrypt($data, $key);



        return $result;
    }

    public static function sslEncryptionData($data)
    {

        // Store cipher method
        $ciphering = "BF-CBC";

        // Use OpenSSl encryption method
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;

        // Use random_bytes() function which gives
        // randomly 16 digit values
        $encryption_iv = random_bytes($iv_length);

        // Alternatively, we can use any 16 digit
        // characters or numeric for iv
        $encryption_key = openssl_digest(php_uname(), 'MD5', TRUE);

        // Encryption of string process starts
        $result = openssl_encrypt($data, $ciphering,
        $encryption_key, $options, $encryption_iv);

        return $result;

    }

    public static function sslDecryptionData($data)
    {
        // echo '<pre>';print_r($data);exit;
        // Store cipher method
        $ciphering = "BF-CBC";

        // Use OpenSSl encryption method
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;


        $decryption_iv = random_bytes($iv_length);

        // Store the decryption key
        $decryption_key = openssl_digest(php_uname(), 'MD5', TRUE);

        // Descrypt the string
        $result = openssl_decrypt ($data, $ciphering,
        $decryption_key, $options, $decryption_iv);



        return $result;
    }
}

