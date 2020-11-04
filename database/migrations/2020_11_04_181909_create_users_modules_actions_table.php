<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateUsersModulesActionsTable.
 */
class CreateUsersModulesActionsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users_modules_actions', function(Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger('user_module_id');
      $table->string('action')->default('index');
      $table->boolean('auth')->default(false);
      $table->timestamps();

      $table->foreign('user_module_id')->references('id')
        ->on('users_modules')->onDelete('cascade')->onUpdate('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('users_modules_actions');
	}
}
