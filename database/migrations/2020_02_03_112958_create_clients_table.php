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
			$table->boolean('active');
			$table->string('person_title')->nullable();
			$table->string('person_name');
			$table->string('company_name')->nullable();
			 
            $table->string('email'); 
			$table->string('phone');
            $table->boolean('is_company')->nullable();  
            $table->string('contract_number');              
            $table->string('vat_number');
			           			
			$table->date('contract_start');
            $table->date('contract_end');            
            $table->text('description')->nullable();
			$table->string('reccurence');
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
