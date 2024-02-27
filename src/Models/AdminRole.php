<?php

/**
 * Created by Reliese Model.
 */

namespace Vector\Spider\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AdminRole
 * 
 * @property int $id
 * @property string $role_title
 * @property string|null $role_desc
 * @property string|null $role_permissions
 * @property int|null $role_sensitive
 * @property int $can_delete
 * 
 * @property Collection|Employee[] $employees
 *
 * @package Vector\Spider\Models
 */
class AdminRole extends Model
{
	protected $table = 'admin_roles';
	public $timestamps = false;

	protected $casts = [
		'role_sensitive' => 'int',
		'role_permissions' => 'array',
		'can_delete' => 'int'
	];

	protected $fillable = [
		'role_title',
		'role_desc',
		'role_permissions',
		'role_sensitive',
		'can_delete'
	];

	public function employees()
	{
		return $this->hasMany(Employee::class);
	}
}
