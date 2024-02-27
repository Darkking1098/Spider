<?php

namespace Vector\Spider\Http\Middleware;

use Vector\Spider\Http\Controllers\AdminControllers\EmployeeController as EmpCon;
use Vector\Spider\Http\Controllers\Controller;
use Vector\Spider\Models\AdminPage;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class AdminApiAuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        /** Redirecting to login if user is not logged in */
        if (!session()->has("adminId"))
            return Controller::api_response(['success'=>false,"msg" => "You are not logged in."]);

        /** Getting Employee data */
        $admin = EmpCon::get_self();

        /** Redirecting to logout if user  is disabled */
        if (!$admin['emp_status'])
            return EmpCon::api_response(['success'=>false,'msg' => "Contact HR"]);

        $uri = $request->route()->uri();
        $uri = substr($uri, 4);
        $page['page_uri'] = $uri;
        if (strpos($uri, "/") !== false) {
            $page = AdminPage::with('admin_page_group')->where("page_uri", $uri)->first();
            if (!$page)
                return EmpCon::api_response(['success'=>false,'msg' => "Page not found"]);
            $page = $page->toArray();
            /** Get Pages allowed to current user */
            $permissions = $admin['admin_role']['role_permissions'];

            if (!$page['page_status'] || ($page['permission_required'] && !($permissions && (in_array($page['id'], $permissions) || $permissions[0] == '*')))) {
                return EmpCon::api_response(['success'=>false,'msg' => "Invalid request"]);
            }
        }
        return $next($request);
    }
}
