<?php
declare(strict_types=1);

use Scraper\Migration\Migration;

final class SimilarWebsites extends Migration
{

	public function up()
	{
		$this->schema->create('similar_sites', function (Illuminate\Database\Schema\Blueprint $table) {
			// Auto-increment id
			$table->id();
			$table->unsignedBigInteger('website_id')->nullable(false);
			$table->string('name')->nullable(false);
			$table->decimal('overlap_score')->nullable(false);

			// Foreign Key Constraints
			$table->foreign('website_id')->references('id')->on('websites');

			// not to duplicate similar sites for the same website
			$table->unique('website_id', 'name');
		});
	}

}
