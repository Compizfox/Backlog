<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model {
    public function purchases() {
    	return $this->belongsToMany(Purchase::class);
    }

    public function dlc() {
    	return $this->hasMany(Dlc::class);
    }

    public function status() {
    	return $this->belongsTo(Status::class);
    }

    public function getFormattedPlaytime() {
	    return round($this->playtime / 60, 2);
    }

    public function getIconUrl() {
    	return "http://media.steampowered.com/steamcommunity/public/images/apps/{$this->appid}/{$this->img_icon_url}.jpg";
    }

	public function getLogoUrl() {
		return "http://media.steampowered.com/steamcommunity/public/images/apps/{$this->appid}/{$this->img_logo_url}.jpg";
	}
}
