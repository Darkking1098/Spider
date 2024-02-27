<?php

namespace Vector\Spider\Http\Controllers\AdminControllers;

use Vector\Spider\Http\Controllers\Controller;
use Vector\Spider\Models\AdminRole;
use Vector\Spider\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    static function get_empById($empId)
    {
        return Employee::with('admin_role')->find($empId);
    }
    static function get_self()
    {
        return self::get_empById(session()->get('adminId'))->toArray();
    }

    function ui_login()
    {
        return session()->has('adminId') ? redirect()->route('admin_home') : view('Spider::admin.login');
    }
    function ui_view_emps()
    {
        $data = [];
        return view('', $data);
    }
    function ui_view_emp()
    {
    }
    function ui_modify_emp()
    {
        $data = ["roles" => AdminRole::all()->toArray()];
        return view('Spider::admin.Employee.modify_employee', $data);
    }
    function ui_view_roles()
    {
        $data = ["roles"=>AdminRole::withcount('employees')->get()->toArray()];
        return view('Spider::admin.Employee.Role.view_roles', $data);
    }
    function ui_modify_role($roleId = null)
    {
        $data = ["groups" => AdminPageController::get_groupsWithAllPages()];
        if ($roleId) {
            $role = AdminRole::find($roleId);
            if($role){
                $data += ["role" => $role->toArray()];
            }else return abort(404);
        }
        return view('Spider::admin.Employee.Role.modify_role', $data);
    }


    function web_login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
        $params = [
            "username" => $request->username,
            "password" => $request->password,
        ];
        $result = self::login($params);
        if ($result['success']) {
            session()->put("adminId", $result['adminId']);
            return redirect()->route('admin_home');
        }
        return self::web_response($result);
    }
    function web_logout(Request $request)
    {
        self::logout();
        return redirect()->route('admin_login');
    }


    function web_modify_emp(Request $request, $empId)
    {
        // To-Do
        $params = null;
        $result = self::update_emp($empId, $params);
        return self::web_response($result);
    }
    function web_modify_role(Request $request, $roleId = null)
    {
        $params = [
            "role_title" => $request->role_title,
            "role_desc" => $request->role_desc,
            "role_permissions" => $request->role_permissions,
            "role_sensitive" => $request->role_sensitive ?? 0,
            "can_delete" => $request->can_delete ?? 0,
        ];
        return self::web_response($roleId ? self::update_role($roleId, $params) : self::create_role($params));
    }



    function login($params)
    {
        $employee = Employee::where('emp_username', $params['username'])->first();
        if ($employee) {
            $ed = $employee->getOriginal();
            if (!$ed['emp_status']) {
                return ["success" => false, "msg" => "Contact HR"];
            } else if ($ed['emp_password'] == $params['password']) {
                // $jwt = JWT::generate(["adminId" => $ed['id']], false);
                // Cookie::queue('jwt', $jwt);
                return ["success" => true, "adminId" => $ed['id']];
            }
        }
        return ["success" => false, "msg" => "Invalid Credentials"];
    }
    function logout()
    {
        return ['success' => session()->flush()];
    }
    function create_emp($params)
    {
        $employee = new Employee();
        return ["success" => $employee->save()];
    }
    function update_emp($empId, $params)
    {
        $employee = Employee::find($empId);
        return ["success" => $employee->save()];
    }
    function toggle_emp_Status($empId)
    {
        $employee = Employee::find($empId);
        return ["success" => $employee->save()];
    }
    function delete_emp($empId, $force)
    {
        $employee = Employee::find($empId);
        return ["success" => $employee->save()];
    }

    function create_role($params)
    {
        $role = new AdminRole($params);
        try {
            $result = $role->save();
            $msg = "Role has been created.";
            $extra = ["role" => $role->toArray()];
        } catch (\Throwable $th) {
            $msg = "Some Error Occured...";
        }
        return ['success' => $result ?? false, 'msg' => $msg] + ($extra ?? []);
    }
    function update_role($roleId, $params)
    {
        $role = AdminRole::find($roleId);
        return ["success" => $role->save()];
    }
    function delete_role($roleId, $force)
    {
        $role = AdminRole::find($roleId);
        return ["success" => $role->save()];
    }
}
