<?php


namespace Scraper\Models;


use Illuminate\Database\Eloquent\Model;

class MonthlyRanking extends Model
{
	public $timestamps = false;

	protected $table = 'rankings_monthly';

	protected $guarded = [];

	protected $touches = ['website'];

	public function website()
	{
		return $this->belongsTo(Website::class);
	}
}
