<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('status');
            $table->string('name_t');
            $table->string('last_name_t');
            $table->string('email')->unique();
            $table->string('work_phone_t');
            $table->string('leaves_day_n');
            $table->string('personal_phone_t');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
			$table->softDeletes();  //add this line
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
