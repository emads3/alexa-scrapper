<?php


namespace Scraper;


use Scraper\Models\Country;
use Scraper\Models\Website;

class DBManager
{


	public function manageWebsiteData($data)
	{
		$websiteData = $data['info'];
		$similarSites = $data['similarSites'];
		$rankings = $data['rankings'];
		$countries = $data['countries'];

		if (count($websiteData) <= 0)
			return;

		$website = Website::updateOrCreate(
			['domain' => $websiteData['domain']],
			$websiteData
		);

		// update similar Websites, if the similar website already exists, just update overlap_score
		foreach ($similarSites as $name => $overlapScore) {
			$website->similarSites()->updateOrCreate(
				['name' => $name],
				['overlap_score' => $overlapScore]
			);
		}

		foreach ($rankings as $date => $ranking) {
			$website->rankings()->updateOrCreate(
				['date' => $date],
				['rank' => $ranking]
			);
		}

		$syncingArr = [];
		foreach ($countries as $country => $percentOfVisits) {

			$countryNameAndCode = explode(';', $country);

			$syncingArr[Country::updateOrCreate(
				['name' => $countryNameAndCode[1]],
				['code' => $countryNameAndCode[0]]
			)->id] = ['percent_of_visits' => $percentOfVisits];

		}

		$website->countries()->sync(
			$syncingArr
		);


		// calculate monthly rankings for rankings (or update monthly ranking)
		$monthlyRankings = array_filter($data['rankings'], function ($key) {
			return str_ends_with($key, '01');
		}, ARRAY_FILTER_USE_KEY);

		foreach ($monthlyRankings as $date => $ranking) {
			$website->monthlyRanking()->updateOrCreate(
				['date' => $date],
				['rank' => $ranking]
			);
		}

	}

}
