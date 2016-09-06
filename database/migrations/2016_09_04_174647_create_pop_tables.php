<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePopTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pops', function (Blueprint $table) {
            $table->increments('id');
            $table->string('identify', 18);
            $table->string('name', 20);
            $table->string('sex', 6);
            $table->string('phone', 20);
            $table->string('address');
            $table->date('birthday');
            $table->string('check_unit', 32);
            $table->string('doctor', 20);
            $table->text('memo');
            $table->text('result');
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
        //
    }
}
