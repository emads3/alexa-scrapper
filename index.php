#! /usr/bin/env php

<?php

require 'vendor/autoload.php';

use Scraper\DBManager;
use Scraper\Parser;

$urls = [
	'https://www.alexa.com/siteinfo/spyguy.com',
	'https://www.alexa.com/siteinfo/nethome.wiki',
	'https://www.alexa.com/siteinfo/emads3.com', // domain with less info
	'https://www.alexa.com/siteinfo/souq.com',
	'https://www.alexa.com/siteinfo/7enkesh.co', // domain that doesn't exist
	'https://www.alexa.com/siteinfo/facebook.com',
];

$db = new DBManager();

foreach ($urls as $url) {

	echo 'Scraping ' . $url . " ..\n";

	$html = file_get_contents($url);
	$parser = new Parser($html);

	echo 'Domain: ' . $parser->extractDomain() . "\n";

	$data['info'] = $parser->parseWebsite();
	$data['similarSites'] = $parser->similarSites();
	$data['rankings'] = $parser->parseRankings();
	$data['countries'] = $parser->countries();

	$db->manageWebsiteData($data);

}
