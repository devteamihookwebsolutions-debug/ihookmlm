<?php

/**
 * This class contains public functions related to MSiteAppLink
 *
 * @package         MSiteAppLink
 * @category        Model
 * @author          Ihook Dev Team
 * @link            https://ihookmlmsoftware.ihookmlmsoftware.com/landingpage/home.html
 * @copyright       Copyright (c) 2025 - 2026, Ihook.
 * @version         Version 1.0
**/
/****************************************************************************
 * Licence Agreement:
 *     This program is a Commercial licensed software. You are not authorized to redistribute it and/or modify/and or sell it under any publication either user and enterprise versions of the License (or) any later version is applicable for the same. If you have received this software without a license, you must not use it, and you must destroy your copy of it immediately. If anybody illegally uses this software, please contact https://ihookmlmsoftware.com.
 *****************************************************************************/
?>
<?php

namespace Admin\App\Models\Middleware;
use Illuminate\Support\Facades\Request;

class MSiteAppLink
{
public static function getSiteAppLink()
{
    // Get the full host name (example: www.example.com)
    $host = request()->getHost();

    // Remove "www." if exists
    if (str_starts_with($host, 'www.')) {
        $host = substr($host, 4);
    }

    // Break domain into parts
    $parts = explode('.', $host, 2);

    if (count($parts) === 2) {
        $subParts = explode('.', $parts[1], 2);

        if (count($subParts) === 2) {
            // If domain has 3 parts -> remove subdomain
            $host = $parts[1];  // example → "example.com"
        }
    }
// dd($host);
    return $host;
}
}

