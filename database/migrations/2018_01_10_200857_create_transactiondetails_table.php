<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactiondetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('transaction_details', function (Blueprint $table) {
            $table->increments('id');
            $table->float('workergrossincome', 7,2);
            $table->float('companygrossincome', 7,2);
            $table->integer('service_id')->unsigned();
            $table->integer('worker_id')->unsigned();
            $table->integer('transaction_id')->unsigned();
            $table->timestamps();

            $table->foreign('service_id')->references('id')->on('services');
            $table->foreign('worker_id')->references('id')->on('workers');
            $table->foreign('transaction_id')->references('id')->on('transactions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_details');
    }
}
