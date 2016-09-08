<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Game
 *
 * @property integer $id
 * @property string $name
 * @property integer $status_id
 * @property string $note
 * @property integer $appid
 * @property integer $playtime
 * @property string $img_icon_url
 * @property string $img_logo_url
 * @property boolean $appid_lock
 * @property boolean $hidden
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Purchase[] $purchases
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Dlc[] $dlc
 * @property-read \App\Status $status
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Playthrough[] $playthroughs
 * @method static \Illuminate\Database\Query\Builder|\App\Game whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Game whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Game whereStatusId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Game whereNote($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Game whereAppid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Game wherePlaytime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Game whereImgIconUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Game whereImgLogoUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Game whereAppidLock($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Game whereHidden($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Game whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Game whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Game extends Model {
	protected $guarded = [];

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