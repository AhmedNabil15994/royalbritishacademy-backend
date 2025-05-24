<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainerProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trainer_profile', function (Blueprint $table) {
            $table->id();
            $table->longText('about');
            $table->string('country');
            $table->string('job_title');
            $table->boolean('status')->default(true);
            $table->string('facebook')->default('#');
            $table->string('linkedin')->default('#');
            $table->string('twitter')->default('#');
            $table->string('instagram')->default('#');
            $table->string('youtube')->default('#');
            $table->bigInteger('trainer_id')->unsigned();
            $table->foreign('trainer_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('trainer_profile');
    }
}
