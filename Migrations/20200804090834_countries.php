<?php
declare(strict_types=1);

use Scraper\Migration\Migration;

final class Countries extends Migration
{
	public function up()
	{
		$this->schema->create('countries', function (Illuminate\Database\Schema\Blueprint $table) {
			// Auto-increment id
			$table->id();
			$table->unsignedBigInteger('website_id');
			$table->unsignedBigInteger('countries_names_id')->nullable(false);
			$table->decimal('percent_of_visits');

			// Foreign Key Constraints
			$table->foreign('website_id')->references('id')->on('websites');
			$table->foreign('countries_names_id')->references('id')->on('countries_names');

			// not to duplicate website with country
			$table->unique(['website_id', 'countries_names_id']);
		});
	}
}
