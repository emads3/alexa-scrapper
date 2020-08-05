<?php


namespace Scraper\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
	protected $table = 'countries_names';

	protected $guarded = [];

	public $timestamps = false;

	protected $touches = ['websites'];


	public function websites()
	{
//		return $this->hasManyThrough('Scraper\Website', WebsiteCountry::class);
		return $this->belongsToMany(
			Website::class,
			'countries',
			'countries_names_id',
			'website_id'
		);
	}

}
