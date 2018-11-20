<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStepTimes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('step_times', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('step_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('spent_time');
            $table->timestamps();

            $table->foreign('step_id')->references('id')->on('steps')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('step_times');
    }
}
