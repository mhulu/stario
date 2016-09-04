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
            $table->string('created_unit', 32);
            $table->string('doctor', 20);
            $table->longText('memo');

            $table->timestamps();
        });

        Schema::create('result', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pop_id')->unsigned();
            $table->boolean('10001');
            $table->boolean('10002');
            $table->boolean('10003');
            $table->boolean('10004');
            $table->boolean('10005');
            $table->boolean('10006');
            $table->boolean('10007');
            $table->boolean('10008');
            $table->boolean('10009');
            $table->boolean('10010');
            $table->boolean('10011');
            $table->boolean('10012');
            $table->boolean('10013');
            $table->boolean('10014');
            $table->boolean('10015');
            $table->boolean('10016');
            $table->boolean('10017');
            $table->boolean('10018');
            $table->boolean('10019');
            $table->boolean('10020');
            $table->boolean('10021');
            $table->boolean('10022');
            $table->boolean('10023');
            $table->boolean('10024');
            $table->boolean('10025');
            $table->text('10099');
            $table->string('10101', 10);
            $table->string('10102', 10);
            $table->string('10103', 10);
            $table->string('10104', 10);
            $table->string('10105', 10);
            $table->string('10106', 10);
            $table->string('10107', 10);
            $table->string('10108', 10);
            $table->string('10109', 10);
            $table->string('10110', 10);
            $table->string('10111', 10);
            $table->tinyInteger('10201')->unsigned();
            $table->tinyInteger('10202')->unsigned();
            $table->tinyInteger('10203')->unsigned();
            $table->tinyInteger('10204')->unsigned();
            $table->tinyInteger('10205')->unsigned();
            $table->tinyInteger('10206')->unsigned();
            $table->tinyInteger('10301')->unsigned();
            $table->tinyInteger('10302')->unsigned();
            $table->tinyInteger('10303')->unsigned();
            $table->string('10304', 60);
            $table->boolean('10401');
            $table->boolean('10402');
            $table->boolean('10403');
            $table->boolean('10404');
            $table->boolean('10405');
            $table->boolean('10406');
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
