<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoneSteps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('step_procedures', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('total_spent_time');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::create('done_steps', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('step_id');
            $table->text('form_data_value');
            $table->unsignedInteger('spent_time');
            $table->unsignedInteger('step_procedure_id');
            $table->timestamps();

            $table->foreign('step_id')->references('id')->on('steps')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('step_procedure_id')->references('id')->on('step_procedures')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('done_steps');
        Schema::dropIfExists('step_procedures');
    }
}
