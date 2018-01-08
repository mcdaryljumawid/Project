<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('servicename', 50);
            $table->float('serviceprice', 6,2);
            $table->smallinteger('serviceduration');
            $table->enum('servicetype', ['Major', 'Minor']);
            $table->enum('servicecategory', ['Hair', 'Threading', 'Nails', 'SPA', 'Eyelash', 'Waxing', 'Massage']);
            
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
        Schema::dropIfExists('services');
    }
}
