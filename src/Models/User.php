<?php

/**
 * Created by Reliese Model.
 */

namespace Vector\Spider\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * 
 * @property int $id
 * @property string $username
 * @property string $fname
 * @property string $password
 * 
 * @property Collection|BlogComment[] $blog_comments
 * @property BlogLike $blog_like
 * @property Collection|BlogWishlist[] $blog_wishlists
 *
 * @package Vector\Spider\Models
 */
class User extends Model
{
	protected $table = 'users';
	public $timestamps = false;

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'username',
		'fname',
		'password'
	];

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
