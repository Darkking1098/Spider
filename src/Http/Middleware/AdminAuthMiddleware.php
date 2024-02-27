<?php

namespace Vector\Spider\Http\Middleware;

use Vector\Spider\Http\Controllers\AdminControllers\EmployeeController as EmpCon;
use Vector\Spider\Models\AdminPage;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        /** Redirecting to login if user is not logged in */
        if (!session()->has("adminId"))
            return redirect()->route("admin_login");

        /** Getting Employee data */
        $admin = EmpCon::get_self();

        /** Redirecting to logout if user  is disabled */
        if (!$admin['emp_status'])
            return EmpCon::web_response(['msg' => "Contact HR"]);
        $uri = strtolower($request->route()->uri());
        $page['page_uri'] = $uri;
        if (strpos($uri, "/") !== false) {
            $page = AdminPage::with('admin_page_group')->where("page_uri", $uri)->first();
            if (!$page) abort(404);
            $page = $page->toArray();
            /** Get Pages allowed to current user */
            $permissions = $admin['admin_role']['role_permissions'];

            if (!$page['page_status'] || ($page['permission_required'] && !($permissions && (in_array($page['id'], $permissions) || $permissions[0] == '*')))) {
                return redirect()->route('admin_home');
            }
        }
        View::share(['admin' => $admin, "current" => $page]);
        return $next($request);
    }
}
