<?php

/**
 * Created by Reliese Model.
 */

namespace Vector\Spider\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BlogWishlist
 * 
 * @property int $id
 * @property int $user_id
 * @property int $blog_id
 * @property Carbon $created_at
 * 
 * @property Blog $blog
 * @property User $user
 *
 * @package Vector\Spider\Models
 */
class BlogWishlist extends Model
{
	protected $table = 'blog_wishlist';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'blog_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'blog_id'
	];

	public function blog()
	{
		return $this->belongsTo(Blog::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
