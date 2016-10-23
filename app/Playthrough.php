<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Playthrough
 *
 * @property integer $id
 * @property integer $playable_id
 * @property integer $playable_type
 * @property string $started_at
 * @property string $ended_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $playable
 * @method static \Illuminate\Database\Query\Builder|\App\Playthrough whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Playthrough wherePlayableId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Playthrough wherePlayableType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Playthrough whereStartedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Playthrough whereEndedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Playthrough whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Playthrough whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Playthrough extends Model {
	protected $guarded = [];

	public function playable() {
		return $this->morphTo();
	}

	public function isEnded() {
		return $this->ended_at != NULL;
	}
}
