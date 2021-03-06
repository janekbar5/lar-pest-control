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
			$table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
			
            $table->integer('status_id_n')->unsigned(); //unsigned only positive val        
            $table->integer('substatus_id_n')->nullable(); //unsigned only positive val        
        
			$table->float('price_n');
			
            $table->string('title_t'); //varchar            
            $table->dateTime('start_t')->nullable();
            $table->dateTime('end_t')->nullable();
			
			$table->text('description')->nullable(); //TEXT equivalent to the table
            $table->text('comment')->nullable(); //TEXT equivalent to the table
			
			$table->dateTime('last_service_t')->nullable();
            // reccurence
            // field workers assigned multiple
            // photos
            $table->softDeletes();  //add this line
            $table->timestamps();
        });
       
   
        Schema::create('task_user', function (Blueprint $table) {			
            //$table->increments('id');	if on error	Multiple primary key defined
            $table->integer('task_id')->unsigned(); //unsigned only positive val
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
            $table->primary(['task_id','user_id']); //prevent repeating (1,1  1,2  1,3  1,1)			
            $table->integer('user_id')->unsigned();											
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');  
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
