<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model {
    public function games() {
    	return $this->belongsToMany(Game::class);
    }

	public function dlc() {
		return $this->belongsToMany(Dlc::class);
	}

	public function getNumChildren() {
		return count($this->games)+count($this->dlc);
	}

	public function getFormattedPrice() {
		return '€ ' . number_format($this->price, 2, ',', ' ');
	}
}
