<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHealthTables extends Migration
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
            $table->string('identify', 20)->index();
            $table->string('password', 66);
            $table->string('name', 10);
            $table->string('sex', 10);
            $table->string('phone', 20);
            $table->string('address');
            $table->date('birthday',12);
            $table->string('check_unit', 32);
            $table->date('check_date');
            $table->string('doctor', 10);
            $table->text('memo')->nullable();
            $table->timestamps();
        });
        Schema::create('pop_health_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pop_id')->unsigned()->nullable();
            $table->text('result');
            $table->timestamps();
            $table->foreign('pop_id')
                        ->references('id')
                        ->on('pops')
                        ->onDelete('cascade')
                        ->onUpdate('cascade');
        });
        Schema::create('geriatrics', function (Blueprint $table) {
            $table->increments('id');
            $table->string('identify', 20)->index();
            $table->string('password', 66);
            $table->string('name', 10);
            $table->string('sex', 10);
            $table->string('phone', 20);
            $table->string('address');
            $table->date('birthday',12);
            $table->string('check_unit', 32);
            $table->date('check_date');
            $table->string('doctor', 10);
            $table->text('memo')->nullable();
            $table->timestamps();
        });
        Schema::create('geriatric_health_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pop_id')->unsigned();
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
        Schema::drop('pops');
        Schema::drop('pop_health_records');
    }
}
