<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned(); //unsigned only positive val
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->integer('client_id');
            //$table->integer('tratment');
            $table->string('title');          
            $table->text('description');                     
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
        Schema::dropIfExists('locations');
    }
}
