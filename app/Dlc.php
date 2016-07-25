<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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