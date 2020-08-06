<?php


namespace Scraper;


class Parser
{
	private $content;

	/**
	 * Extractor constructor.
	 * @param $content
	 */
	public function __construct($content)
	{
		$this->content = $content;
	}

	public function parseWebsite()
	{
		return [
				'domain'           => $this->extractDomain(),
				'current_rank'     => $this->currentRank(),
				'main_country'     => $this->mainCountry(),
				'top_keywords'     => $this->topKeywords(),
				'percent_search'   => $this->percentSearch(),
				'linking_websites' => $this->linkingWebsites(),
			] + $this->siteMetrics();
	}

	public function extractDomain()
	{
		$pattern = '/<h1><strong>.*<\/strong>/U';

		preg_match($pattern, $this->content, $matches);

		return str_replace(['<h1><strong>', '</strong>'], '', $matches[0]);
	}

	public function currentRank()
	{
		$rankings = (array)$this->parseRankings();

		return count($rankings) ? end($rankings) : null;
	}

	/**
	 * @return array of key => value (date => rank)
	 * ['20200507' => '437521', ....]
	 */
	public function parseRankings(): array
	{

		$pattern = '/{\"3mrank\".*}}/';
		preg_match($pattern, $this->content, $match);
		$rankings = json_decode($match[0], true)['3mrank'];

		// convert string ranking to int
		foreach ($rankings as $key => $value) {
			$rankings[$key] = (integer)$value;
		}

		return $rankings;
	}

	// TODO after extracting all countries this can be derived from another method
	public function mainCountry()
	{
		$pattern = '/<div id="countryName">(.*)<\/div>/U';
		preg_match_all($pattern, $this->content, $matches);

		if (count($matches[0]) === 0) return null;

		$countryWithCode = explode('&nbsp;', $matches[1][0]);

		return $countryWithCode[1];
	}

	public function topKeywords()
	{
		$kw = $this->selector(
			'<div class="ACard Half topkeywords withcompoundtooltips" id="card_topkeywords">',
			'<div class="ADropdown competitorList outer" id="topKeywordsDropdown">',
			$this->content,
			["\r\n", "\n", "\r", "\t", "  "],
			false
		);

		if (empty($kw)) return null;

		$pattern = '/keyword\ (.|\n)*<span class="truncation">(.*)<\/span>/U';

		preg_match_all($pattern, $kw, $keywordsWithPercentage);

		return implode(';', $keywordsWithPercentage[2]);
	}

	private function selector($start_str = "", $end_str = "", $html = "", $replacer = [], $strip_tags = true): string
	{
		$start_data = explode($start_str, $html);
		if (empty($start_data[1])) return '';
		$end_data = explode($end_str, $start_data[1]);

		$out = $end_data[0];

		if ($strip_tags) {
			$out = strip_tags($out);
		}

		if (count($replacer)) {
			$out = str_replace($replacer, "", $out);
		}

		return trim($out);
	}

	public function percentSearch()
	{
		$percentSearchSection = $this->selector(
			'<div class="ringchart referral-social"',
			'<div class="title">Search',
			$this->content,
			[],
			false
		);

		if (empty($percentSearchSection)) return null;

		$pattern = '/data-referral\=\"(.*)\"/U';
		preg_match($pattern, $percentSearchSection, $match);

		return (float)$match[1];
	}

	public function linkingWebsites()
	{
		$linkingSites = $this->selector(
			'<section class="linksin">',
			'<h3>Total Sites Linking In</h3>',
			$this->content,
			[],
			false
		);

		$pattern = '/<span class="big data">(.*)<\/span>/U';

		preg_match($pattern, $linkingSites, $match);

		if (empty($match))
			return null;

		return (integer)str_replace(',', '', $match[1]);
	}

	public function siteMetrics(): array
	{
		// pattern that matches 3 blocks texts (3 in 1) for optimization purpose
		// 1- Daily Page views per Visitor
		// 2- Daily Time on Site
		// 3- Bounce rate

		$metricsHtml = $this->selector(
			'<div class="ACard Half metrics " id="card_metrics">',
			'Total Sites Linking In',
			$this->content,
			["\r\n", "\n", "\r", "\t", "  "],
			false
		);

		$metricsHtml = trim($metricsHtml, " \t\n\r\0\x0B");

		$pattern = '/<p class="small data">(.+)(<span|<\/p)+/U';
		preg_match_all($pattern, $metricsHtml, $matches);

		// nullify if not set, otherwise trim and clean
		$daily_pageviews_per_visitor = isset($matches[1][0]) ? trim($matches[1][0], " -") : null;
		$daily_time_on_site = isset($matches[1][1]) ? trim($matches[1][1], " -") : null;
		$bounce_rate = isset($matches[1][2]) ? trim($matches[1][2], "% -") : null;

		// combine metrics' values into array
		$metrics = compact(
			"daily_pageviews_per_visitor",
			"daily_time_on_site",
			"bounce_rate",
		);

		// nullify empty strings
		foreach ($metrics as $key => $value)
			if (empty($value)) $metrics[$key] = null;


		// convert string to float
		if (isset($metrics['daily_pageviews_per_visitor']))
			$metrics['daily_pageviews_per_visitor'] = (float)$metrics['daily_pageviews_per_visitor'];

		// convert string to float
		if (isset($metrics['bounce_rate']))
			$metrics['bounce_rate'] = (float)$metrics['bounce_rate'];

		return $metrics;
	}

	public function countries()
	{
		$countriesWithPercentages = $this->selector(
			'<section class="country">',
			'<strong>Visitors by Country</strong>',
			$this->content,
			["\r\n", "\n", "\r", "\t", "  "],
			false
		);

		$pattern = '/<li.*id\=\"countryName\">(.+)<\/div>.*id\=\"countryPercent\">(.+)<\/div>/U';
		preg_match_all($pattern, $countriesWithPercentages, $matches);

		$websiteCountries = [];

		for ($i = 0, $iMax = count($matches[1]); $i < $iMax; ++$i) {

			$countryWithCodeSeparated = str_replace('&nbsp;', ';', $matches[1][$i]);
			$countryPercentOfVisits = (float)str_replace('%', ';', $matches[2][$i]);

			$websiteCountries[$countryWithCodeSeparated] = $countryPercentOfVisits;
		}

		return $websiteCountries;
	}

	// USELESS and heavy

	public function bounceRate(): float
	{
		$pattern = '/<div class=\"Third sectional\">\n.*<p class=\"small data\">\n.*.pull-right\">/';
		preg_match($pattern, $this->content, $matches);
		$str = trim($matches[0], " \t\n\r\0\x0B");
		$str = str_replace(["\r\n", "\n", "\r", "\t", "  "], '', $str);
		$str = $this->selector(
			'<div class="Third sectional"><p class="small data">',
			' <span class="delta rank opposite up pull-right">',
			$str,
			['%']
		);

		return (float)$str;
	}

	public function similarSites()
	{
		$similarSitesSection = $this->selector(
			'Similar sites that share the same visitors and search keywords with this site.',
			'<strong>Similar Sites</strong>',
			$this->content,
			["\r\n", "\n", "\r", "\t", "  "],
			false
		);

		$similarSitesSection = $this->selector(
			'<section class="table ">',
			'</div></section>',
			$similarSitesSection,
			[],
			false
		);

		$pattern = '/<div class=\"Row.*class\=\"overlap\ \"\ data-popsicle\=\"(.+)\".*class\=\"site\ \"\ data-popsicle\=\"(.+)\"/U';

		preg_match_all($pattern, $similarSitesSection, $matches);

		$similarSitesWithOverlapScore = [];

		for ($i = 0, $iMax = count($matches[1]); $i < $iMax; ++$i) {
			$similarSitesWithOverlapScore[$matches[2][$i]] = (float)$matches[1][$i];
		}

		return $similarSitesWithOverlapScore;

	}
}
