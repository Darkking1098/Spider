<?php

/**
 * Created by Reliese Model.
 */

namespace Vector\Spider\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AuthToken
 * 
 * @property int $id
 * @property string $token
 * @property string $data
 * @property int $issue
 * @property int|null $expiry
 * @property int|null $refresh
 *
 * @package Vector\Spider\Models
 */
class AuthToken extends Model
{
	protected $table = 'auth_tokens';
	public $timestamps = false;

	protected $casts = [
		'issue' => 'int',
		'expiry' => 'int',
		'refresh' => 'int'
	];

	protected $hidden = [
		'token'
	];

	protected $fillable = [
		'token',
		'data',
		'issue',
		'expiry',
		'refresh'
	];
}
