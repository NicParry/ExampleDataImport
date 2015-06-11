<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::dropIfExists('departments');

		Schema::create('departments', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('department_name');
            $table->string('contact_name');
            $table->string('contact_email');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::dropIfExists('departments');
	}

}
