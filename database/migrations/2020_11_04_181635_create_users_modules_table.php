<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateUsersModulesTable.
 */
class CreateUsersModulesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users_modules', function(Blueprint $table) {
      $table->increments('id');
      $table->unsignedBigInteger('user_id');
      $table->unsignedInteger('module_id');
      $table->boolean('auth')->default(false);
      $table->timestamps();

      $table->foreign('user_id')->references('id')
        ->on('users')->onDelete('cascade')->onUpdate('cascade');
      $table->foreign('module_id')->references('id')
        ->on('modules')->onUpdate('cascade')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('users_modules');
	}
}
