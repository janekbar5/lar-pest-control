<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');	
			$table->string('photoable_type');			                
	        $table->integer('photoable_id');	
			$table->integer('user_id')->unsigned(); //unsigned only positive val
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');			
			$table->string('path');
			$table->integer('image_order')->unsigned(); //unsigned only positive val
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
        Schema::dropIfExists('images');
    }
}
