<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned(); //unsigned only positive val
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            	
			$table->string('addressable_type');			                
	        $table->integer('addressable_id');
			$table->string('address_line1');
			$table->string('address_line2');
			$table->string('city');
            $table->string('postcode');
            $table->decimal('lat', 10, 7);
            $table->decimal('lng', 10, 7);
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
        Schema::dropIfExists('addresses');
    }
}
