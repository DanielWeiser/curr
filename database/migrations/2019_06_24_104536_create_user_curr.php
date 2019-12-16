<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCurr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_curr', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('curr_id');
            $table->boolean('curr_state');
            $table->boolean('req_flag');
            $table->timestamps();
        });
        Schema::table('user_curr', function($table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('curr_id')->references('id')->on('currency');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_curr');
    }
}
