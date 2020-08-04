<?php
declare(strict_types=1);

use Scraper\Migration\Migration;

final class Websites extends Migration
{
	public function up()
	{
		$this->schema->create('websites', function (Illuminate\Database\Schema\Blueprint $table) {
			// Auto-increment id
			$table->id();
			$table->string('domain')->unique()->nullable(false);
			$table->integer('current_rank')->nullable();
			$table->decimal('bounce_rate')->nullable();
			$table->decimal('daily_pageviews_per_visitor')->nullable();
			$table->time('daily_time_on_site')->nullable();
			$table->string('main_country')->nullable();
			$table->text('top_keywords')->nullable();
			$table->decimal('percent_search')->nullable();
			$table->integer('linking_websites')->nullable();

			// Foreign Key Constraints
			// $table->foreign('country_id')->references('id')->on('countries');

			// Required for Eloquent's created_at and updated_at columns
			$table->timestamps();
		});
	}
}
