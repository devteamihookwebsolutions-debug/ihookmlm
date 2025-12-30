<?php
namespace Admin\App\Models\Middleware;
use Admin\App\Models\Member\Package;
use DateTime;

class MPackageDetails
{

    public static function getPackageDetails($package_id)
    {
        // Retrieve the first record matching the package_id
        return Package::where('package_id', $package_id)->first();
    }


    public static function getParamPackageDetails($param = '*', $where = [])
    {
        if (!is_array($where)) {
            $where = ['package_id' => $where];
        }

        $columns = $param === '*' ? ['*'] : array_map('trim', explode(',', $param));

        return Package::select($columns)->where($where)->first();
    }
}
