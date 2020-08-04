<?php
declare(strict_types=1);

use Scraper\Migration\Migration;

final class CountriesNames extends Migration
{
	public function up()
	{
		$this->schema->create('countries_names', function (Illuminate\Database\Schema\Blueprint $table) {
			// Auto-increment id
			$table->id();
			$table->string('name')->nullable(false)->unique();
			$table->string('code');
		});
	}
}
