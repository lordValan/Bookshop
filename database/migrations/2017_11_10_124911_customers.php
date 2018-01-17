<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Customers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers_opinion', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 128);
            $table->string('status', 128);
            $table->string('photo', 128);
            $table->string('opinion', 512);
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
        Schema::dropIfExists('customers_opinion');
    }
}
