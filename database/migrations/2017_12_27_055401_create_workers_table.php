<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workers', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->string('workerfname', 50);
            $table->string('workerlname', 50);
            $table->string('workermname', 50);
            $table->date('workerdbirth');
            $table->string('workerbrgy', 30);
            $table->string('workertown', 30);
            $table->string('workerprovince', 30);
            $table->enum('workergender', ['Male', 'Female']);
            $table->enum('workermaritalStatus', ['Single', 'Married']);
            $table->string('workerContactNo', 12);
            $table->enum('workerlevel', ['Low', 'High']);
            $table->enum('workertype', ['Barber', 'All-around (Rebond specialized)', 'All-around (Haircut specialized)']);
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
        Schema::dropIfExists('workers');
    }
}
