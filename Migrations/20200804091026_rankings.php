<?php
declare(strict_types=1);

use Scraper\Migration\Migration;

final class Rankings extends Migration
{
	public function up()
	{
		$this->schema->create('rankings', function (Illuminate\Database\Schema\Blueprint $table) {
			// Auto-increment id
			$table->id();
			$table->unsignedBigInteger('website_id');
			$table->date('date');
			$table->integer('rank');

			// Foreign Key Constraints
			$table->foreign('website_id')->references('id')->on('websites');
		});
	}
}
