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
            $table->string('name'); 
            $table->string('email');  
            $table->boolean('is_company');  
            $table->string('contract_number');
            $table->date('contract_start');  
            $table->string('vat_number');
            $table->string('person_name');   
            $table->string('person_title');
            $table->date('contract_end');            
            $table->text('description');
            //recurrence


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
