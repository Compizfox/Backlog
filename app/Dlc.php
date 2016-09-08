<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Dlc
 *
 * @property integer $id
 * @property string $name
 * @property integer $status_id
 * @property string $note
 * @property integer $game_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Purchase[] $purchases
 * @property-read \App\Game $game
 * @property-read \App\Status $status
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Playthrough[] $playthroughs
 * @method static \Illuminate\Database\Query\Builder|\App\Dlc whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Dlc whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Dlc whereStatusId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Dlc whereNote($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Dlc whereGameId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Dlc whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Dlc whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Dlc extends Model {
	protected $table = 'dlc';
	protected $guarded = [];

	public function purchases() {
		return $this->belongsToMany(Purchase::class);
	}

	public function game() {
		return $this->belongsTo(Game::class);
	}

	public function status() {
		return $this->belongsTo(Status::class);
	}

	public function playthroughs() {
		return $this->morphMany(Playthrough::class, 'playable');
	}
}