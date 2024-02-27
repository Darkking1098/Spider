<?php

namespace Vector\Spider\Http\Controllers\BaseControllers;

use Vector\Spider\Http\Controllers\Controller;
use Vector\Spider\Models\WebImage;
use Illuminate\Http\Request;

class SEOBase extends Controller
{
    function send_image($theme, $varient, $slug)
    {
        $image = self::get_image($slug);
        return response()->file(public_path("webimage/".$image['webimage_srcset'][$theme][$varient]));
    }
    static function get_image($src)
    {
        return WebImage::where('webimage_slug', $src)->first()->toArray();
    }
}
