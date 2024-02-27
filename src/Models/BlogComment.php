<?php

/**
 * Created by Reliese Model.
 */

namespace Vector\Spider\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BlogComment
 * 
 * @property int $id
 * @property int $user_id
 * @property int $blog_id
 * @property int|null $comment_id
 * @property string $comment_text
 * @property int $comment_status
 * @property Carbon $created_at
 * 
 * @property Blog $blog
 * @property User $user
 * @property BlogComment|null $blog_comment
 * @property Collection|BlogComment[] $blog_comments
 *
 * @package Vector\Spider\Models
 */
class BlogComment extends Model
{
	protected $table = 'blog_comments';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'blog_id' => 'int',
		'comment_id' => 'int',
		'comment_status' => 'int'
	];

	protected $fillable = [
		'user_id',
		'blog_id',
		'comment_id',
		'comment_text',
		'comment_status'
	];

	public function blog()
	{
		return $this->belongsTo(Blog::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function blog_comment()
	{
		return $this->belongsTo(BlogComment::class, 'comment_id');
	}

	public function blog_comments()
	{
		return $this->hasMany(BlogComment::class, 'comment_id');
	}
}
