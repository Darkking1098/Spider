<?php

/**
 * Created by Reliese Model.
 */

namespace Vector\Spider\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AdminPageGroup
 * 
 * @property int $id
 * @property string $page_group_title
 * @property int $page_group_index
 * @property int $page_group_status
 * @property int $can_delete
 * 
 * @property Collection|AdminPage[] $admin_pages
 *
 * @package Vector\Spider\Models
 */
class AdminPageGroup extends Model
{
	protected $table = 'admin_page_group';
	public $timestamps = false;

	protected $casts = [
		'page_group_index' => 'int',
		'page_group_status' => 'int',
		'can_delete' => 'int'
	];

	protected $fillable = [
		'page_group_title',
		'page_group_index',
		'page_group_status',
		'can_delete'
	];

	public function admin_pages()
	{
		return $this->hasMany(AdminPage::class, 'page_group_id');
	}
}
