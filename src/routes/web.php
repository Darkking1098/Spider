<?php

use Illuminate\Support\Facades\Route;
use Vector\Spider\Http\Controllers\BaseControllers\SEOBase;

Route::get('webimage/{theme}/{varient}/{slug}', [SEOBase::class, "send_image"]);