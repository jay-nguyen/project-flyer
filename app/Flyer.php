<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flyer extends Model
{
	/**
	 * Fillable fields for a flyer.
	 * @var array
	 */
	protected $fillable = [
		'street',
		'city',
		'state',
		'country',
		'zip',
		'price',
		'description'

	];

	/**
	 * Scope query to those located at a given address.
	 * @param  Builder $query
	 * @param  [type] $zip    [description]
	 * @param  [type] $street [description]
	 * @return Builder         [description]
	 */
	public function scopeLocatedAt($query, $zip, $street) {
		$street = str_replace('-', ' ', $street);

		return $query->where(compact('zip', 'street'));
	}

	public function getPriceAttribute($price) {
		return '$' . number_format($price);
	}


	/**
	 * A flyer is composed of many photos.
	 * @return Illuminate\Database\Eloquent\Relations\HasMany
	 */
    public function photos () {
    	return $this->hasMany('App\Photo');
    }
}