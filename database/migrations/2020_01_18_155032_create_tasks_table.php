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
            $table->integer('location_id')->unsigned(); //unsigned only positive val
            $table->integer('treatment_id')->unsigned(); //unsigned only positive val
            $table->integer('status_id')->unsigned(); //unsigned only positive val
            $table->integer('price_id')->unsigned(); //unsigned only positive val
            //$table->integer('user_id')->unsigned(); //unsigned only positive val
            //$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('title'); //varchar	
            $table->text('description')->nullable(); //TEXT equivalent to the table
            $table->text('comment')->nullable(); //TEXT equivalent to the table
            $table->dateTime('deadline');
            // reccurence
            // field workers assigned multiple
            // photos
            $table->softDeletes();  //add this line
            $table->timestamps();
        });
   //App\User::create(['location_id' => 1,'treatment_id' => 1,'status_id' => 1,'price_id' => '1','title'=>'Task 1' ]);      
        
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
