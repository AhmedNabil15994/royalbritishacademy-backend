<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObtainCredentialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obtain_credentials', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['created', 'pending', 'loaded'])->default('created');
            $table->text('client_payload');
            $table->string('api_video_id');
            $table->enum('created', ['created','pending','loaded'])->default('created');
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
        Schema::dropIfExists('obtain_credentials');
    }
}
