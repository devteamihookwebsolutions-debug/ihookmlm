<?php
/**
 * This class contains public static functions related to amazon buckets.
 *
 * @package         MAmazonS3
 * @category        Model
 * @author          Sunsofty Dev Team
 * @link            https://promlmsoftware.com
 * @copyright      Copyright (c) 2020 - 2023, Sunsofty.
 * @version        Version 8.1
 */
/****************************************************************************
* Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact info@promlmsoftware.com.
*****************************************************************************/
?>
<?php
namespace Admin\App\Models\Middleware;
use Aws\S3\S3Client;
class MAmazonS3{

    /**
     * This public static function is used to upload in amazon buckets.
    */
   public static function amazonUpload($filename, $filetmpname, $filetype, $filekey)
    {

            if (CURRENT_FOLDER!='main') {
                $filepath = '../' . $_ENV['CURRENT_UPATH'] . '/';
            }
            $uploadcheckkeycdn = trim($_ENV['CDNUPLOADURL']);
            $uploadcheckkeycdn = explode('/', $uploadcheckkeycdn);
            $bucket = end($uploadcheckkeycdn).'ext';
            $uploadkey1 = $_ENV['CDNUPLOADURL1'];
            $uploadkey1 = MCryptoGraphy::decryptionData($uploadkey1);
            $uploadkey2 = $_ENV['CDNUPLOADURL2'];
            $uploadkey2 = MCryptoGraphy::decryptionData($uploadkey2);
            $s3 = new S3Client(['region' => $_ENV['AWS_REGION'], 'version' => 'latest', 'credentials' => ['key' => $uploadkey1, 'secret' => $uploadkey2,]]);
            $key = $filekey;
            $pathInS3 = $filetmpname;


            // $params = [
            //     'Bucket' => $bucket,
            //     'Key' => $key,
            //     'SourceFile' => $pathInS3,
            //     'ContentType' => $filetype,
            //     'ContentDisposition' => 'inline',
            //     'StorageClass' => 'STANDARD',
            //     'acl' => 'PUBLIC-READ',
            //     'CacheControl' => 'max-age=172800',
            // ];


            // echo '<pre>';
            // print_r($params); exit;
            $s3->putObject(
                [
                    'Bucket' => $bucket, 'Key' => $key, 'SourceFile' => $pathInS3,
                    'ContentType' => $filetype, 'ContentDisposition' => 'inline', 'StorageClass' => 'STANDARD', 'acl' => 'PUBLIC-READ',
                    'CacheControl' => 'max-age=172800',
                ]
            );

    }
     /**
     * This public static function is used to remove file from amazon buckets.
     * @return bool data
    */
    public static function removeAmazonFile($filenamekey)
    {
        if (strpos($_ENV['CDNUPLOADURL'], 'promlmuploads') == false) {
            if (CURRENT_FOLDER!='main') {
                $filepath = '../' . $_ENV['CURRENT_UPATH'] . '/';
            }
            $uploadcheckkeycdn = trim($_ENV['CDNUPLOADURL']);
            $uploadcheckkeycdn = explode('/', $uploadcheckkeycdn);
            $bucket = end($uploadcheckkeycdn);
            $uploadkey1 = $_ENV['CDNUPLOADURL1'];
            $uploadkey1 = MCryptoGraphy::decryptionData($uploadkey1);
            $uploadkey2 = $_ENV['CDNUPLOADURL2'];
            $uploadkey2 = MCryptoGraphy::decryptionData($uploadkey2);
            $s3 = new S3Client(['region' => $_ENV['AWS_REGION'], 'version' => 'latest', 'credentials' => ['key' => $uploadkey1, 'secret' => $uploadkey2,]]);
            $s3->deleteObject(['Bucket' => $bucket, 'Key' => $filenamekey]);
            return true;
        }
    }
    /**
     * This public static function is used to files list from amazon buckets.
     * @return array data
    */
    public static function getObjectList($Prefix)
    {

            if (CURRENT_FOLDER!='main') {
                $filepath = '../' . $_ENV['CURRENT_UPATH'] . '/';
            }
            $uploadcheckkeycdn = trim($_ENV['CDNUPLOADURL']);
            $uploadcheckkeycdn = explode('/', $uploadcheckkeycdn);
            $bucket = end($uploadcheckkeycdn);
            $uploadkey1 = $_ENV['CDNUPLOADURL1'];
            $uploadkey1 = MCryptoGraphy::decryptionData($uploadkey1);
            $uploadkey2 = $_ENV['CDNUPLOADURL2'];
            $uploadkey2 = MCryptoGraphy::decryptionData($uploadkey2);
            $s3 = new S3Client(['region' => $_ENV['AWS_REGION'], 'version' => 'latest', 'credentials' => ['key' => $uploadkey1, 'secret' => $uploadkey2,]]);
            $objects = $s3->getIterator('ListObjects', array("Bucket" => $bucket, "Prefix" => $Prefix));
            return $objects;

    }


    /**
     * This public static function is used to files creation in amazon buckets.
     * @return bool data
    */
    public static function amazonFileCreation($filetmpname, $filetype, $filekey)
    {


            $temp_path = $filetmpname;
            $file = fopen($temp_path, "r");

            if ($_ENV['CURRENT_FOLDER']!='main') {
                $filepath = '../' . $_ENV['CURRENT_UPATH'] . '/';
            }
            $uploadcheckkeycdn = trim($_ENV['CDNUPLOADURL']);
            $uploadcheckkeycdn = explode('/', $uploadcheckkeycdn);
            $bucket = end($uploadcheckkeycdn).'ext';
            $uploadkey1 = $_ENV['CDNUPLOADURL1'];
            $uploadkey1 = MCryptoGraphy::decryptionData($uploadkey1);
            $uploadkey2 = $_ENV['CDNUPLOADURL2'];
            $uploadkey2 = MCryptoGraphy::decryptionData($uploadkey2);
            $s3 = new S3Client(['region' => $_ENV['AWS_REGION'], 'version' => 'latest', 'credentials' => ['key' => $uploadkey1, 'secret' => $uploadkey2,]]);
            $key = $filekey;
            $pathInS3 = $filetmpname;


            $s3->deleteObject([
                'Bucket' => $bucket,
                'Key' => $key
            ]);

            // Then upload the new file
            $s3->putObject([
                'Bucket' => $bucket,
                'Key' => $key,
                'SourceFile' => $pathInS3,
                'Body' => $file,
                'ContentType' => $filetype,
                'acl' => 'PUBLIC-READ',
                'CacheControl' => 'no-store, no-cache, must-revalidate, max-age=0',
                'Expires' => '0'
            ]);



            // $s3->putObject(
            //     [
            //         'Bucket' => $bucket, 'Key' => $key, 'SourceFile' => $pathInS3,
            //         'Body' => $file,'ContentType' => $filetype, 'ContentDisposition' => 'inline', 'StorageClass' => 'STANDARD', 'acl' => 'PUBLIC-READ',
            //         'CacheControl' => 'no-cache, no-store, must-revalidate',
            //         'Expires' => '0'
            //     ]
            // );


            fclose($file);
            unlink($temp_path);

        return true;
    }

}

?>
