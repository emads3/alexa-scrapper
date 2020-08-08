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

			// in order to store emoji like country code 🇺🇸
			$table->charset = 'utf8mb4';
			$table->collation = 'utf8mb4_unicode_ci';
		});
	}
}
