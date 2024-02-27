<?php

/**
 * Created by Reliese Model.
 */

namespace Vector\Spider\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BlogCategory
 * 
 * @property int $id
 * @property string $blog_category_title
 * @property string $blog_category_desc
 * @property string $blog_category_image
 * @property int $blog_category_status
 * 
 * @property Collection|Blog[] $blogs
 *
 * @package Vector\Spider\Models
 */
class BlogCategory extends Model
{
	protected $table = 'blog_categories';
	public $timestamps = false;

	protected $casts = [
		'blog_category_status' => 'int'
	];

	protected $fillable = [
		'blog_category_title',
		'blog_category_desc',
		'blog_category_image',
		'blog_category_status'
	];

	public function blogs()
	{
		return $this->hasMany(Blog::class);
	}
}
