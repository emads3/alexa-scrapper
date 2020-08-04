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
			$table->unsignedBigInteger('website_id');
			$table->string('name');
			$table->decimal('overlap_score');

			// Foreign Key Constraints
			$table->foreign('website_id')->references('id')->on('websites');
		});
	}

}
