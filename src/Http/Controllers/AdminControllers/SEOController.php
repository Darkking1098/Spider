<?php

namespace Vector\Spider\Http\Controllers\AdminControllers;

use Vector\Spider\Http\Controllers\BaseControllers\SEOBase;
use Vector\Spider\Models\WebImage;
use Vector\Spider\Models\WebPage;
use Illuminate\Http\Request;

class SEOController extends SEOBase
{
    protected $file_path;

    // Constructor to initialize the property
    public function __construct()
    {
        // Set the value of $file_path in the constructor
        $this->file_path = public_path('webimage');
    }

    function ui_view_webpages()
    {
        $data = ["webPages" => WebPage::all()->toArray()];
        return view('Spider::admin.WebPage.view_webpages', $data);
    }
    function ui_view_webpage($webPageId)
    {
        $webPage = WebPage::find($webPageId);
        if ($webPage) {
            $data = ["webPage" => $webPage->toArray()];
            return view('Spider::admin.WebPage.view_webpage', $data);
        }
        return abort(404);
    }
    function ui_modify_webpage($webPageId = null)
    {
        if (isset($webPageId)) {
            $webPage = WebPage::find($webPageId);
            if (!$webPage) return abort(404);
            $data = ["webPage" => $webPage->toArray()];
        }
        return view('Spider::admin.WebPage.modify_webpage', $data ?? []);
    }

    function ui_view_webimages()
    {
        $data = ["webImages" => WebImage::all()->toArray()];
        return view('Spider::admin.WebImage.view_webimages', $data);
    }
    function ui_view_webimage($webImageId)
    {
        $webImage = WebImage::find($webImageId);
        if (isset($webImage)) {
            $data = ["webImage" => $webImage->toArray()];
            return view('Spider::admin.WebImage.view_webimage', $data);
        }
        return abort(404);
    }
    function ui_modify_webimage($webImageId = null)
    {
        if (isset($webImageId)) {
            $webImage = WebImage::find($webImageId);
            if (!$webImage) return abort(404);
            $data = ["webImage" => $webImage->toArray()];
        }
        return view('Spider::admin.WebImage.modify_webimage', $data ?? []);
    }

    function web_modify_webpage(Request $request, $webPageId = null)
    {
        $params = [
            "webpage_slug" => $request->webpage_slug,
            "webpage_title" => $request->webpage_title,
            "webpage_desc" => $request->webpage_desc,
            "webpage_keywords" => $request->webpage_keywords,
            "webpage_canonical" => $request->webpage_canonical,
            "webpage_other_meta" => $request->webpage_other_meta,
            "webpage_status" => $request->webpage_status ?? 0,
            "can_delete" => $request->can_delete ?? 0,
        ];
        return self::web_response($webPageId ? self::update_webpage($webPageId, $params) : self::create_webpage($params));
    }
    function web_modify_webimage(Request $request, $webImageId = null)
    {
        $params = [
            "webimage_slug" => $request->webimage_slug,
            "webimage_alt" => $request->webimage_alt,
            "webimage_caption" => $request->webimage_caption,
            "webimage_status" => $request->webimage_status,
            "can_delete" => $request->can_delete,
        ];
        return self::web_response($webImageId ? self::update_webimage($webImageId, $params, $request->images) : self::create_webimage($params, $request->images));
    }

    function api_toggle_webpage_status($webPageId)
    {
        return self::api_response(self::toggle_webpage_status($webPageId));
    }
    function api_delete_webpage($webPageId)
    {
        return self::api_response(self::delete_webpage($webPageId, request('force', false)));
    }
    function api_toggle_webimage_status($webImageId)
    {
        return self::api_response(self::toggle_webimage_status($webImageId));
    }
    function api_delete_webimage($webImageId)
    {
        return self::api_response(self::delete_webimage($webImageId, request('force', false)));
    }

    function create_webpage($params)
    {
        $params['webpage_slug'] = strtolower($params['webpage_slug']);
        $webPage = WebPage::where("webpage_slug", $params['webpage_slug'])->first();
        if (!$webPage) {
            $webpage = new WebPage($params);
            try {
                $result = $webpage->save();
                $msg = "Webpage Created Successfully...";
                $extra = ["webpage" => $webpage->toArray()];
            } catch (\Throwable $th) {
                $msg = "Some Error Occured...";
            }
        } else $msg = "This slug already exists.";
        return ['success' => $result ?? false, 'msg' => $msg] + ($extra ?? []);
    }
    function update_webpage($webPageId, $params)
    {
        $temp = WebPage::where("webpage_slug", $params['webpage_slug'])->first();
        $webPage = WebPage::find($webPageId);
        if ($webPage) {
            if (!$temp || $temp['id'] == $webPageId) {
                try {
                    $result = $webPage->update($params);
                    $msg = "Webpage updated successfully...";
                } catch (\Throwable $th) {
                    $msg = "Some Error Occured...";
                }
            } else $msg = "This slug already exists.";
        }
        return ['success' => $result ?? false, 'msg' => $msg ?? "WebPage not exists"];
    }
    function toggle_webpage_status($webPageId)
    {
        $webPage = WebPage::find($webPageId);
        if ($webPage) {
            $webPage->webpage_status = !$webPage->webpage_status;
            try {
                $result = $webPage->save();
                $msg = "Webpage status changed.";
                $extra = ["status" => $webPage->webpage_status ? "ACTIVE" : "DISABLED"];
            } catch (\Throwable $th) {
                $msg = "Some Error Occured...";
            }
        }
        return ['success' => $result ?? false, 'msg' => $msg ?? "WebPage not exists"] + ($extra ?? []);
    }
    function delete_webpage($webPageId, $force)
    {
        $webPage = WebPage::find($webPageId);
        if ($webPage) {
            if ($webPage->can_delete || $force) {
                try {
                    $result = $webPage->delete();
                    $msg = "WebPage deleted successfully";
                } catch (\Throwable $th) {
                    $msg = "Some Error Occured...";
                }
            } else $msg = "WebPage can not be deleted.";
        }
        return ['success' => $result ?? false, 'msg' => $msg ?? "WebPage does not exist."];
    }

    function create_webimage($params, $raw_images)
    {
        if (!$raw_images) return ['success' => false, "msg" => "Image not provided"];
        $images = [];
        try {
            foreach ($raw_images as $theme => $srcsets) {
                $temp = [];
                foreach ($srcsets as $srcset) {
                    if (isset($srcset['file'])) {
                        $x = self::move_file($srcset['file']);
                        $temp[$srcset['size']] = $x['filename'];
                    }
                }
                if ($temp) $images[$theme] = $temp;
            }
            if (!isset($images['default']['default'])) return ['success' => false, "msg" => "Default Image not provided"];
            $webImage = new WebImage($params + ["webimage_srcset" => $images]);
            $result = $webImage->save();
            $msg = "Webimage Uploaded Successfully...";
            $extra = ["webImage" => $webImage->toArray()];
        } catch (\Throwable $th) {
            $msg = "Some Error Occured...";
        }
        return ['success' => $result ?? false, 'msg' => $msg] + ($extra ?? []);
    }
    function update_webimage($webImageId, $params, $newImages)
    {
        $webImage = WebImage::find($webImageId);
        $oldImages = $webImage->webimage_srcset;
        $images = [];
        if ($webImage) {
            try {
                foreach ($newImages as $theme => $srcsets) {
                    $temp = [];
                    foreach ($srcsets as $srcset) {
                        if (isset($srcset['file'])) {
                            $x = self::move_file($srcset['file']);
                            $temp[$srcset['size']] = $x['filename'];
                        } else if (isset($oldImages[$theme][$srcset['size']])) {
                            $temp[$srcset['size']] = $oldImages[$theme][$srcset['size']];
                        }
                    }
                    if ($temp) $images[$theme] = $temp;
                }
                $result = $webImage->update($params + ["webimage_srcset" => $images]);
                $msg = "Webpage updated successfully...";
                $extra = ["webImage" => $webImage->toArray()];
            } catch (\Throwable $th) {
                $msg = "Some Error Occured...";
            }
        }
        return ['success' => $result ?? false, 'msg' => $msg ?? "WebImage not exists"] + ($extra ?? []);
    }
    function toggle_webimage_status($webImageId)
    {
        $webImage = WebImage::find($webImageId);
        if ($webImage) {
            $webImage->webimage_status = !$webImage->webimage_status;
            try {
                $result = $webImage->save();
                $msg = "Webpage status changed.";
                $extra = ["status" => $webImage->webimage_status ? "ACTIVE" : "DISABLED"];
            } catch (\Throwable $th) {
                $msg = "Some Error Occured...";
            }
        }
        return ['success' => $result ?? false, 'msg' => $msg ?? "WebImage not exists"] + ($extra ?? []);
    }
    function delete_webimage($webImageId, $force)
    {
        $webImage = WebImage::find($webImageId);
        if ($webImage) {
            if ($webImage->can_delete || $force) {
                try {
                    $result = $webImage->delete();
                    $msg = "WebImage deleted successfully";
                } catch (\Throwable $th) {
                    $msg = "Some Error Occured...";
                }
            } else $msg = "WebImage can not be deleted.";
        }
        return ['success' => $result ?? false, 'msg' => $msg ?? "WebImage does not exist."];
    }
}
