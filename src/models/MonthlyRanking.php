<?php


namespace Scraper\Models;


use Illuminate\Database\Eloquent\Model;

class MonthlyRanking extends Model
{
	protected $table = 'rankings_monthly';

	protected $guarded = [];

	protected $touches = ['website'];

	public function website()
	{
		return $this->belongsTo(Website::class);
	}
}
