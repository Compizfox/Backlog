<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dlc extends Model {
	protected $table = 'dlc';

	public function purchases() {
		return $this->belongsToMany(Purchase::class);
	}

	public function game() {
		return $this->belongsTo(Game::class);
	}

	public function status() {
		return $this->belongsTo(Status::class);
	}
}
