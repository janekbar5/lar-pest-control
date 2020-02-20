<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTreatmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('treatments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned(); //unsigned only positive val
            //$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');  
            //$table->integer('tratment');
            $table->string('title');            
            //$table->text('description'); 
            $table->softDeletes();  //add this line                
            $table->timestamps();
        });

        Schema::create('location_treatment', function (Blueprint $table) {			
            //$table->increments('id');	if on error	Multiple primary key defined
			$table->integer('location_id')->unsigned(); //unsigned only positive val
			//$table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
			//$table->primary(['location_id','treatment_id']); //prevent repeating (1,1  1,2  1,3  1,1)			
			$table->integer('treatment_id')->unsigned();											
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
        Schema::dropIfExists('treatments');
    }
}
