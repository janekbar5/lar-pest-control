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
			$table->integer('active_n');
			$table->integer('client_type_n');
			$table->integer('reccurence_id_n');
			$table->string('name_t');
            $table->string('email_t'); 
			$table->string('phone_n');
			/////optional			
			$table->string('person_title')->nullable();
            $table->string('person_name_t')->nullable();  
            $table->string('contract_number_n')->nullable();              
            $table->string('vat_number_t')->nullable();
			           			
			$table->date('contract_start_t');
            $table->date('contract_end_t');            
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
