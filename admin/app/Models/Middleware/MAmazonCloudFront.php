<?php
namespace Admin\App\Models\Middleware;
use Admin\App\Models\Middleware\MCryptoGraphy;
use Aws;
class MAmazonCloudFront
{
public static function getCloudFrontUrl($filename)
{
    return config('cdn.cloudfront_url') . '/' . ltrim($filename, '/');
}

}