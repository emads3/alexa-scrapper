<?php


namespace Scraper\Models;


use Illuminate\Database\Eloquent\Model;

class SimilarSite extends Model
{
	public $timestamps = false;

	protected $guarded = [];

	protected $touches = ['website'];

	public function website()
	{
		return $this->belongsTo(Website::class);
	}
}
