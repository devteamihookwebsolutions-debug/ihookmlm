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

