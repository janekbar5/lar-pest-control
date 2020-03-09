<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('active');
			$table->integer('client_type');
			$table->integer('reccurence_id');
			$table->string('name');
            $table->string('email'); 
			$table->string('phone');
			/////optional			
			$table->string('person_title')->nullable();
            $table->string('person_name')->nullable();  
            $table->string('contract_number')->nullable();              
            $table->string('vat_number')->nullable();
			           			
			$table->date('contract_start');
            $table->date('contract_end');            
            $table->text('description')->nullable();
			
            //recurrence
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
        Schema::dropIfExists('clients');
    }
}
