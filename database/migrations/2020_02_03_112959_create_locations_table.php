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
            
            //$table->integer('client_id')->unsigned();
			//$table->foreign('client_id')->references('id')->on('clients');
            
            $table->string('title_t');          
            $table->text('description'); 
			$table->string('surface_n');
			$table->float('price_n');
            $table->softDeletes();  //add this line
            $table->timestamps();     
        });
		
		
		
		Schema::create('client_location', function (Blueprint $table) {			
            //$table->increments('id');	if on error	Multiple primary key defined
            $table->integer('client_id')->unsigned(); //unsigned only positive val
            $table->foreign('client_id')->references('id')->on('clients');
            $table->primary(['client_id','location_id']); //prevent repeating (1,1  1,2  1,3  1,1)			
            $table->integer('location_id')->unsigned();											
            $table->foreign('location_id')->references('id')->on('locations');  
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
