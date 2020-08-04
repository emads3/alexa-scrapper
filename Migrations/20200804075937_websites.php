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
			$table->integer('current_rank');
			$table->decimal('bounce_rate');
			$table->decimal('daily_pageviews_per_visitor');
			$table->time('daily_time_on_site');
			$table->string('main_country');
			$table->text('top_keywords');
			$table->decimal('percent_search');
			$table->integer('linking_websites');

			// Foreign Key Constraints
			// $table->foreign('country_id')->references('id')->on('countries');

			// Required for Eloquent's created_at and updated_at columns
			$table->timestamps();
		});
	}
}
