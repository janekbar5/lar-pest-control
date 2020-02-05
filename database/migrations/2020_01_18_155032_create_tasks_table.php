<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');   
			$table->integer('user_id')->unsigned(); //unsigned only positive val
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			
            $table->integer('location_id')->unsigned(); //unsigned only positive val           
            $table->integer('status_id')->unsigned(); //unsigned only positive val        
        
			$table->float('price');
            $table->string('title'); //varchar	
            $table->text('description')->nullable(); //TEXT equivalent to the table
            $table->text('comment')->nullable(); //TEXT equivalent to the table
            $table->dateTime('start');
            $table->dateTime('end');
            // reccurence
            // field workers assigned multiple
            // photos
            $table->softDeletes();  //add this line
            $table->timestamps();
        });
       
   
        Schema::create('task_user', function (Blueprint $table) {			
            //$table->increments('id');	if on error	Multiple primary key defined
            $table->integer('task_id')->unsigned(); //unsigned only positive val
            //$table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->primary(['task_id','user_id']); //prevent repeating (1,1  1,2  1,3  1,1)			
            $table->integer('user_id')->unsigned();											
            //$table->foreign('treatment_id')->references('id')->on('treatments')->onDelete('cascade');  
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
        Schema::dropIfExists('tasks');
    }
}
