<?php

/**
 * Created by Reliese Model.
 */

namespace Vector\Spider\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AdminPage
 * 
 * @property int $id
 * @property int $page_group_id
 * @property string $page_title
 * @property string $page_uri
 * @property string|null $page_uri_desc
 * @property int $page_can_display
 * @property int $page_status
 * @property int $permission_required
 * @property int $can_delete
 * 
 * @property AdminPageGroup $admin_page_group
 *
 * @package Vector\Spider\Models
 */
class AdminPage extends Model
{
	protected $table = 'admin_pages';
	public $timestamps = false;

	protected $casts = [
		'page_group_id' => 'int',
		'page_can_display' => 'int',
		'page_status' => 'int',
		'permission_required' => 'int',
		'can_delete' => 'int'
	];

	protected $fillable = [
		'page_group_id',
		'page_title',
		'page_uri',
		'page_uri_desc',
		'page_can_display',
		'page_status',
		'permission_required',
		'can_delete'
	];

	public function admin_page_group()
	{
		return $this->belongsTo(AdminPageGroup::class, 'page_group_id');
	}
}
