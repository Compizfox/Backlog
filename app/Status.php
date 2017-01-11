<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Status
 *
 * @property integer $id
 * @property string $name
 * @property boolean $completed
 * @property string $color
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Game[] $games
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Dlc[] $dlc
 * @method static \Illuminate\Database\Query\Builder|\App\Status whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Status whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Status whereCompleted($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Status whereColor($value)
 * @mixin \Eloquent
 */
class Status extends Model {
	protected $guarded = [];

	public function games() {
		return $this->hasMany(Game::class);
	}

	public function dlc() {
		return $this->hasMany(Dlc::class);
	}
}
