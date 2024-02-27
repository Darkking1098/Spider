<?php

/**
 * Created by Reliese Model.
 */

namespace Vector\Spider\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeeTeam
 * 
 * @property int $id
 * @property int|null $department_id
 * @property string $team_name
 * @property string|null $team_desc
 * @property string|null $team_image
 * @property int $team_leader
 * 
 * @property EmployeeDepartment|null $employee_department
 * @property Employee $employee
 * @property Collection|Employee[] $employees
 *
 * @package Vector\Spider\Models
 */
class EmployeeTeam extends Model
{
	protected $table = 'employee_teams';
	public $timestamps = false;

	protected $casts = [
		'department_id' => 'int',
		'team_leader' => 'int'
	];

	protected $fillable = [
		'department_id',
		'team_name',
		'team_desc',
		'team_image',
		'team_leader'
	];

	public function employee_department()
	{
		return $this->belongsTo(EmployeeDepartment::class, 'department_id');
	}

	public function employee()
	{
		return $this->belongsTo(Employee::class, 'team_leader');
	}

	public function employees()
	{
		return $this->hasMany(Employee::class, 'team_id');
	}
}
