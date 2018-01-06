<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->string('custfname', 50);
            $table->string('custlname', 50);
            $table->string('custmname', 50);
            $table->enum('custgender', ['Male', 'Female']);
            $table->string('custContactNo', 12);
            $table->string('email', 50);
            $table->string('custUsername', 50);
            $table->string('password');
            $table->timestamps();
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
