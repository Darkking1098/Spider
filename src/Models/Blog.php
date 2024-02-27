<?php

/**
 * Created by Reliese Model.
 */

namespace Vector\Spider\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Blog
 * 
 * @property int $id
 * @property int $writer_id
 * @property int $webpage_id
 * @property int $blog_category_id
 * @property string $blog_img
 * @property string $blog_title
 * @property string $blog_content
 * @property int $blog_status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property WebPage $web_page
 * @property BlogCategory $blog_category
 * @property Employee $employee
 * @property Collection|BlogComment[] $blog_comments
 * @property BlogLike $blog_like
 * @property Collection|BlogWishlist[] $blog_wishlists
 *
 * @package Vector\Spider\Models
 */
class Blog extends Model
{
	protected $table = 'blogs';

	protected $casts = [
		'writer_id' => 'int',
		'webpage_id' => 'int',
		'blog_category_id' => 'int',
		'blog_status' => 'int'
	];

	protected $fillable = [
		'writer_id',
		'webpage_id',
		'blog_category_id',
		'blog_img',
		'blog_title',
		'blog_content',
		'blog_status'
	];

	public function web_page()
	{
		return $this->belongsTo(WebPage::class, 'webpage_id');
	}

	public function blog_category()
	{
		return $this->belongsTo(BlogCategory::class);
	}

	public function employee()
	{
		return $this->belongsTo(Employee::class, 'writer_id');
	}

	public function blog_comments()
	{
		return $this->hasMany(BlogComment::class);
	}

	public function blog_like()
	{
		return $this->hasOne(BlogLike::class);
	}

	public function blog_wishlists()
	{
		return $this->hasMany(BlogWishlist::class);
	}
}
