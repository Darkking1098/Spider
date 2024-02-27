<?php

/**
 * Created by Reliese Model.
 */

namespace Vector\Spider\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class WebPage
 * 
 * @property int $id
 * @property string $webpage_slug
 * @property string|null $webpage_title
 * @property string|null $webpage_desc
 * @property string|null $webpage_keywords
 * @property string|null $webpage_canonical
 * @property string|null $webpage_other_meta
 * @property int|null $load_count
 * @property int $webpage_status
 * @property int|null $can_delete
 * 
 * @property Collection|Blog[] $blogs
 *
 * @package Vector\Spider\Models
 */
class WebPage extends Model
{
	protected $table = 'web_pages';
	public $timestamps = false;

	protected $casts = [
		'load_count' => 'int',
		'webpage_status' => 'int',
		'can_delete' => 'int'
	];

	protected $fillable = [
		'webpage_slug',
		'webpage_title',
		'webpage_desc',
		'webpage_keywords',
		'webpage_canonical',
		'webpage_other_meta',
		'load_count',
		'webpage_status',
		'can_delete'
	];

	public function blogs()
	{
		return $this->hasMany(Blog::class, 'webpage_id');
	}
}
