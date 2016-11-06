<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Purchase
 *
 * @property integer $id
 * @property string $shop
 * @property float $price
 * @property string $valuta
 * @property string $note
 * @property string $purchased_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Game[] $games
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Dlc[] $dlc
 * @method static \Illuminate\Database\Query\Builder|\App\Purchase whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Purchase whereShop($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Purchase wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Purchase whereValuta($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Purchase whereNote($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Purchase wherePurchasedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Purchase whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Purchase whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Purchase extends Model {
	protected $guarded = [];

    public function games() {
    	return $this->belongsToMany(Game::class);
    }

	public function dlc() {
		return $this->belongsToMany(Dlc::class);
	}

	public function getNumChildren() {
		return $this->games->count() + $this->dlc->count();
	}

	public function getFormattedPrice() {
		return $this->valuta . ' ' . number_format($this->price, 2, ',', ' ');
	}

	public function setPurchasedAtAttribute($value) {
		$this->attributes['purchased_at'] = $value ?: null;
	}
}
