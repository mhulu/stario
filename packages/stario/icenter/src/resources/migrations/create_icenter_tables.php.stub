<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIcenterTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
             $table->increments('id');
             $table->string('mobile', 12)->unique();
             $table->string('email');
             $table->string('im_token')->comment('RongCloud Token');
             $table->string('password');
             $table->rememberToken();
             $table->tinyInteger('unit_id')->unsigned();
             $table->timestamp('last_login');
             $table->string('last_ip',45);
             $table->timestamps();
        });

        Schema::create('units', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 60);
            $table->string('label', 100);
            $table->timestamps();
        });

        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('realname', 10);
            $table->string('avatar', 100);
            $table->boolean('sex');
            $table->string('birthplace', 80);
            $table->smallInteger('birthYear')->unsigned();
            $table->tinyInteger('birthMonth')->unsigned();
            $table->tinyInteger('birthDay')->unsigned();
            $table->timestamps();
        });
                
        Schema::create('apps', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 60);
            $table->string('description', 100);
            $table->string('icon', 60);
            $table->timestamps();
        });

        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 32);
            $table->string('url', 50);
            $table->string('icon', 32);
            $table->string('description', 50);
            $table->integer('app_id')->unsigned()->nullable();
            $table->tinyInteger('parent_id')->unsigned()->default(0);
            $table->timestamps();

            $table->foreign('app_id')->references('id')->on('apps')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::drop('apps');
        // Schema::drop('menus');
        Schema::drop('units');
        Schema::drop('profiles');
        Schema::drop('messages');
    }
}
