<?php

/**
 * Created by Reliese Model.
 */

namespace Vector\Spider\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Employee
 * 
 * @property int $id
 * @property int|null $admin_role_id
 * @property int|null $team_id
 * @property string $emp_username
 * @property string $emp_name
 * @property string $emp_gender
 * @property string|null $emp_desc
 * @property string|null $emp_profile_img
 * @property string|null $emp_banner_img
 * @property string $emp_password
 * @property int|null $emp_salary
 * @property int $can_join_teams
 * @property int $emp_status
 * @property int $can_delete
 * 
 * @property AdminRole|null $admin_role
 * @property EmployeeTeam|null $employee_team
 * @property Collection|Blog[] $blogs
 * @property Collection|EmployeeDepartment[] $employee_departments
 * @property Collection|EmployeeTeam[] $employee_teams
 *
 * @package Vector\Spider\Models
 */
class Employee extends Model
{
	protected $table = 'employees';
	public $timestamps = false;

	protected $casts = [
		'admin_role_id' => 'int',
		'team_id' => 'int',
		'emp_salary' => 'int',
		'can_join_teams' => 'int',
		'emp_status' => 'int',
		'can_delete' => 'int'
	];

	protected $hidden = [
		'emp_password'
	];

	protected $fillable = [
		'admin_role_id',
		'team_id',
		'emp_username',
		'emp_name',
		'emp_gender',
		'emp_desc',
		'emp_profile_img',
		'emp_banner_img',
		'emp_password',
		'emp_salary',
		'can_join_teams',
		'emp_status',
		'can_delete'
	];

	public function admin_role()
	{
		return $this->belongsTo(AdminRole::class);
	}

	public function employee_team()
	{
		return $this->belongsTo(EmployeeTeam::class, 'team_id');
	}

	public function blogs()
	{
		return $this->hasMany(Blog::class, 'writer_id');
	}

	public function employee_departments()
	{
		return $this->hasMany(EmployeeDepartment::class, 'department_head');
	}

	public function employee_teams()
	{
		return $this->hasMany(EmployeeTeam::class, 'team_leader');
	}
}
