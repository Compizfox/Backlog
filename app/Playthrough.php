<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Playthrough extends Model {
    public function playable() {
    	return $this->morphTo();
    }
}
