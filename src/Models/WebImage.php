<?php

/**
 * Created by Reliese Model.
 */

namespace Vector\Spider\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class WebImage
 * 
 * @property int $id
 * @property string $webimage_slug
 * @property string|null $webimage_alt
 * @property string|null $webimage_caption
 * @property string|null $webimage_srcset
 * @property int $webimage_status
 * @property int $load_count
 * @property int $can_delete
 *
 * @package Vector\Spider\Models
 */
class WebImage extends Model
{
	protected $table = 'web_images';
	public $timestamps = false;

	protected $casts = [
		'webimage_status' => 'int',
		'load_count' => 'int',
		'can_delete' => 'int',
		'webimage_srcset' => 'array'
	];

	protected $fillable = [
		'webimage_slug',
		'webimage_alt',
		'webimage_caption',
		'webimage_srcset',
		'webimage_status',
		'load_count',
		'can_delete'
	];
}
