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

    public function playthroughs() {
	    return $this->morphMany(Playthrough::class, 'playable');
    }

    public function getFormattedPlaytime() {
	    return round($this->playtime / 60, 2);
    }

    public function getImageUrl(string $type = 'icon') : string {
    	$steamUrl = "http://media.steampowered.com/steamcommunity/public/images/apps/";
    	// Check if the game is linked to Steam
    	if(!empty($this->appid)) {
    		if($type == 'icon') return $steamUrl . "{$this->appid}/{$this->img_icon_url}.jpg";
		    elseif($type == 'logo') return $steamUrl . "{$this->appid}/{$this->img_logo_url}.jpg";
		    else throw new \InvalidArgumentException;
	    } else {
		    if($type == 'icon') return asset('images/game-icon.png');
		    elseif($type == 'logo') return asset('images/game-logo.png');
		    else throw new \InvalidArgumentException;
	    }
    }
}