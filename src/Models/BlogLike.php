<?php

/**
 * Created by Reliese Model.
 */

namespace Vector\Spider\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BlogLike
 * 
 * @property int $id
 * @property int $user_id
 * @property int $blog_id
 * @property Carbon $created_at
 * 
 * @property User $user
 * @property Blog $blog
 *
 * @package Vector\Spider\Models
 */
class BlogLike extends Model
{
	protected $table = 'blog_likes';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'user_id' => 'int',
		'blog_id' => 'int'
	];

	protected $fillable = [
		'id',
		'user_id',
		'blog_id'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function blog()
	{
		return $this->belongsTo(Blog::class);
	}
}
