<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateUsersChecksTable.
 */
class CreateUsersChecksTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users_checks', function(Blueprint $table) {
      $table->increments('id');
      $table->unsignedBigInteger('users_id');
      $table->dateTime('start');
      $table->dateTime('end')->nullable();
      $table->timestamps();

      $table->foreign('users_id')->on('users')->references('id')
          ->onDelete('cascade')->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users_checks');
	}
}
