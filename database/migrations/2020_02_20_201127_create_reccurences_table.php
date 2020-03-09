<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReccurencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reccurences', function (Blueprint $table) {
            $table->increments('id');   						
            $table->string('title'); //varchar
			//$table->integer('days');
            $table->softDeletes();  //add this line
            $table->timestamps();
        });
		            
		App\Reccurence::create(['title' => 'Requested']);
		App\Reccurence::create(['title' => 'Bi-monthly']);
		App\Reccurence::create(['title' => 'Monthly']);
		App\Reccurence::create(['title' => '2 Months']);
		App\Reccurence::create(['title' => '3 Months']);
		App\Reccurence::create(['title' => '6 Months']);
		App\Reccurence::create(['title' => 'Yearly']);
		App\Reccurence::create(['title' => 'Custom']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reccurences');
    }
}
