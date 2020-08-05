<?php


namespace Scraper\Models;


use Illuminate\Database\Eloquent\Model;

class Ranking extends Model
{
	public $timestamps = false;

	protected $guarded = [];

	protected $touches = ['website'];

	public function website()
	{
		return $this->belongsTo(Website::class);
	}
}
