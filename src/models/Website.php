<?php


namespace Scraper\Models;


use Illuminate\Database\Eloquent\Model;


class Website extends Model
{
	protected $guarded = [];

	public function rankings()
	{
		return $this->hasMany(Ranking::class);
	}

	public function monthlyRanking()
	{
		return $this->hasMany(MonthlyRanking::class);
	}

	public function similarSites()
	{
		return $this->hasMany(SimilarSite::class);
	}

	public function countries()
	{
		/*foreach ($website->countries as $country) {
			echo $country->pivot->percent_of_visits;
		}*/

		return $this->belongsToMany(
			Country::class,
			'countries',
			'website_id',
			'countries_names_id'
		);

	}
}
