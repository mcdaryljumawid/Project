<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('appointDateTime');
            $table->datetime('datetimeResched');
            $table->enum('appointStatus', ['Pending','Cancelled','Closed']);
            $table->string('appointRemarks', 150);
            $table->timestamps();
            $table->integer('service_id')->unsigned();
            $table->integer('worker_id')->unsigned();
            $table->integer('customer_id')->unsigned();

            $table->foreign('service_id')->references('id')->on('services');
            $table->foreign('worker_id')->references('id')->on('workers');
            $table->foreign('customer_id')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
