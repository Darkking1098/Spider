<?php

/**
 * Created by Reliese Model.
 */

namespace Vector\Spider\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EmployeeDepartment
 * 
 * @property int $id
 * @property int $department_head
 * @property string $department_name
 * @property string $department_desc
 * @property string $department_logo
 * @property int $department_status
 * @property int $created_on
 * 
 * @property Employee $employee
 * @property Collection|EmployeeTeam[] $employee_teams
 *
 * @package Vector\Spider\Models
 */
class EmployeeDepartment extends Model
{
	protected $table = 'employee_departments';
	public $timestamps = false;

	protected $casts = [
		'department_head' => 'int',
		'department_status' => 'int',
		'created_on' => 'int'
	];

	protected $fillable = [
		'department_head',
		'department_name',
		'department_desc',
		'department_logo',
		'department_status',
		'created_on'
	];

	public function employee()
	{
		return $this->belongsTo(Employee::class, 'department_head');
	}

	public function employee_teams()
	{
		return $this->hasMany(EmployeeTeam::class, 'department_id');
	}
}
