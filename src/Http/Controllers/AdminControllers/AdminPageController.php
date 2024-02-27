<?php

namespace Vector\Spider\Http\Controllers\AdminControllers;

use Illuminate\Http\Request;
use Vector\Spider\Models\AdminPage;
use Vector\Spider\Models\AdminPageGroup;
use Vector\Spider\Http\Controllers\Controller;

class AdminPageController extends Controller
{
    static function get_groups()
    {
        return AdminPageGroup::withCount('admin_pages')->get()->toArray();
    }
    static function get_groupById($groupId)
    {
        return AdminPageGroup::with('admin_pages')->find($groupId);
    }
    static function get_groupsWithPages()
    {
        return AdminPageGroup::with(['admin_pages' => function ($query) {
            $query->where('page_status', 1)->where('page_can_display', 1);
        }])->orderBy('page_group_index')->get()->toArray();
    }
    static function get_groupsWithAllPages()
    {
        return AdminPageGroup::with('admin_pages')->orderBy('page_group_index')->get()->toArray();
    }
    static function get_groupsWithActivePages()
    {
        return AdminPageGroup::with(['admin_pages' => function ($query) {
            $query->where('page_status', 1);
        }])->orderBy('page_group_index')->get()->toArray();
    }
    static function get_pages()
    {
        return AdminPage::with('admin_page_group')->get()->toArray();
    }
    static function get_pageById($pageId)
    {
        return AdminPage::with('admin_page_group')->find($pageId);
    }
    function get_pageByURI($uri)
    {
        return AdminPage::with('admin_page_group')->where('page_uri', $uri)->get()->toArray();
    }
    static function get_allowedPages()
    {
        $groups = [];
        $temp_pages = self::get_groupsWithPages();
        $permitted = EmployeeController::get_self()['admin_role']['role_permissions'];
        if ($permitted && $permitted[0] == "*") return $temp_pages;
        for ($i = 0; $i < count($temp_pages); $i++) {
            $allowed = [];
            foreach ($temp_pages[$i]['admin_pages'] as $page) {
                if (!$page['permission_required'] || ($permitted && in_array($page['id'], $permitted))) $allowed[] = $page;
            }
            if ($allowed) {
                $temp_pages[$i]['admin_pages'] = $allowed;
                $groups[] = $temp_pages[$i];
            }
        }
        return $groups;
    }

    function ui_view_pages()
    {
        $data = ["pages" => self::get_pages()];
        return view('Spider::admin.AdminPage.view_pages', $data);
    }
    function ui_view_page($pageId)
    {
        $page = self::get_pageById($pageId);
        if ($page) {
            $data = ["page" => $page->toArray()];
            return view('Spider::admin.AdminPage.view_page', $data);
        }
        return abort(404);
    }
    function ui_modify_page($pageId = null)
    {
        if ($pageId) {
            $data = ["page" => self::get_pageById($pageId), 'groups' => AdminPageGroup::all()->toArray()];
        } else {
            $data = ["groups" => AdminPageGroup::all()->toArray()];
        }
        return view('Spider::admin.AdminPage.modify_page', $data);
    }
    function ui_view_groups()
    {
        $data = ["groups" => AdminPageGroup::withCount('admin_pages')->orderBy('page_group_index')->get()->toArray()];
        return view('Spider::admin.AdminPage.view_groups', $data);
    }
    function ui_view_group($groupId)
    {
        $group = self::get_groupById($groupId);
        if ($group) {
            $data = ["group" => $group->toArray()];
            return view('Spider::admin.AdminPage.view_group', $data);
        }
        return abort(404);
    }
    function ui_modify_group($groupId = null)
    {
        if ($groupId)
            $data = ["group" => self::get_groupById($groupId)];
        return view('Spider::admin.AdminPage.modify_group', $data ?? []);
    }

    function web_modify_page(Request $request, $pageId = null)
    {
        $params = [
            "page_group_id" => $request->page_group,
            "page_uri" => $request->page_uri,
            "page_title" => $request->page_title,
            "page_uri_desc" => $request->page_uri_desc,
            "page_can_display" => $request->can_display ?? 0,
            "page_status" => $request->page_status ?? 0,
            "permission_required" => $request->permission_required ?? 0,
            "can_delete" => $request->can_delete ?? 0
        ];
        return self::web_response($pageId ? self::update_page($pageId, $params) : self::create_page($params));
    }
    function web_modify_group(Request $request, $groupId = null)
    {
        $params = [
            "page_group_title" => $request->group_title,
            "page_group_index" => $request->group_index,
            "page_group_status" => $request->group_status,
            "can_delete" => $request->can_delete ?? 1
        ];
        return self::web_response($groupId ? self::update_group($groupId, $params) : self::create_group($params));
    }

    function api_toggle_page_status($pageId)
    {
        return self::api_response(self::toggle_page_status($pageId));
    }
    function api_delete_page($pageId)
    {
        return self::api_response(self::delete_page($pageId, request('force', false)));
    }
    function api_toggle_group_status($groupId)
    {
        return self::api_response(self::toggle_group_status($groupId));
    }
    function api_delete_group($pageId)
    {
        return self::api_response(self::delete_group($pageId, request('force', false)));
    }

    function create_page($params)
    {
        $uri = strtolower($params['page_uri']);
        if ($uri[0] == '/') $uri = substr($uri, 1);
        if ($uri[strlen($uri) - 1] == '/') $uri = substr($uri, 0, strlen($uri) - 1);
        $params['page_uri'] = $uri;
        $page = self::get_pageByURI($params['page_uri']);
        if ($page) {
            return ["success" => false, 'msg' => "Page URI already exists. You can edit if you want."];
        } else {
            $page = new AdminPage($params);
            $result = $page->save();
            $newPage = $result ? ["page" => self::get_pageById($page->id)] : [];
            return ["success" => $result, 'msg' => $result ? "\"$page->page_uri\" is added to list. You can now use it." : "Some error occured..."] + $newPage;
        }
    }
    function update_page($pageId, $params)
    {
        $page = AdminPage::find($pageId);
        if ($page) {
            $params['webpage_slug'] = strtolower($params['webpage_slug']);
            try {
                $result = $page->update($params);
                $msg = "Webpage updated successfully...";
                $extra = ["page" => $page->toArray()];
            } catch (\Throwable $th) {
                $msg = "Some Error Occured...";
            }
        }
        return ["success" => $result ?? false, "msg" => $msg ?? "Page does not exist"] + ($extra ?? []);
    }
    function toggle_page_status($pageId)
    {
        $page = AdminPage::find($pageId);
        if ($page) {
            $page->page_status = !$page->page_status;
            try {
                $result = $page->save();
                $msg = "Page status changed...";
                $extra = ["status" => $page->page_status ? "ACTIVE" : "DISABLED"];
            } catch (\Throwable $th) {
                $msg = "Some Error Occured...";
            }
        }
        return ["success" => $result ?? false, "msg" => $msg ?? "Page does not exist"] + ($extra ?? []);
    }
    function delete_page($pageId, $force)
    {
        $page = AdminPage::find($pageId);
        if ($page) {
            if ($page->can_delete || $force) {
                try {
                    $result = $page->delete();
                    $msg = "Page deleted successfully";
                } catch (\Throwable $th) {
                    $msg = "Some Error Occured...";
                }
            } else $msg =  "Page can not be deleted";
        }
        return ["success" => $result ?? false, "msg" => $msg ?? "Page does not exist."];
    }

    function create_group($params)
    {
        $group = new AdminPageGroup($params);
        try {
            $result = $group->save();
            $msg = "\"$group->page_group_title\" group has been created.";
            $extra = ["webImage" => $group->toArray()];
        } catch (\Throwable $th) {
            $msg = "Some Error Occured...";
        }
        return ['success' => $result ?? false, 'msg' => $msg] + ($extra ?? []);
    }
    function update_group($groupId, $params)
    {
        $group = AdminPageGroup::find($groupId);
        if ($group) {
            try {
                $result = $group->update($params);
                $msg = "Group updated successfully...";
                $extra = ["group" => $group->toArray()];
            } catch (\Throwable $th) {
                $msg = "Some Error Occured...";
            }
        }
        return ['success' => $result ?? false, 'msg' => $msg ?? "Group not exists"] + ($extra ?? []);
    }
    function toggle_group_status($groupId)
    {
        $group = AdminPageGroup::find($groupId);
        if ($group) {
            $group->page_group_status = !$group->page_group_status;
            try {
                $result = $group->save();
                $extra = ["status" => $group->page_group_status ? "ACTIVE" : "DISABLED"];
                $msg = "Group status changed.";
            } catch (\Throwable $th) {
                $msg = "Some Error Occured...";
            }
        }
        return ["success" => $result ?? false,  "msg" => $msg ?? "Group does not exist."] + ($extra ?? []);
    }
    function delete_group($groupId, $force)
    {
        $group = self::get_groupById($groupId);
        if ($group) {
            if ($group->can_delete || $force) {
                if ($force) $group->admin_pages()->delete();
                try {
                    $success = $group->delete();
                    $msg = "Group deleted successfully.";
                } catch (\Throwable $th) {
                    $msg = "Some error occured...";
                }
            } else $msg =  "Group can not be deleted";
        }
        return ["success" => $success ?? false, "msg" => $msg ?? "Group does not exist."];
    }
}
