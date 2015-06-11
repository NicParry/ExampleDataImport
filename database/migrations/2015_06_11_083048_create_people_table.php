<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeopleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::dropIfExists('people');

		Schema::create('people', function(Blueprint $table)
		{
            $table->increments('id');
            $table->string('first_name');
            $table->string('surname');
            $table->string('email');
            $table->char('gender', 1);
            $table->integer('department_id')->unsigned();
            $table->foreign('department_id')->references('id')->on('departments');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::dropIfExists('people');
	}

}
