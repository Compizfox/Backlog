<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model {
	public function games() {
		return $this->hasMany(Game::class);
	}

	public function dlc() {
		return $this->hasMany(Dlc::class);
	}
}
