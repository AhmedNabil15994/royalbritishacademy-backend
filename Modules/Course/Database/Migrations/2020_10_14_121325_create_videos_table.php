<?php

use Modules\Course\Entities\Lesson;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Course\Entities\LessonContent;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('thumb')->nullable();
            $table->string('video_link')->default('#');
            $table->string('video_length')->nullable();
            $table->boolean('status')->default(false);
            $table->enum('loading_status', ['processing','loaded','failed'])->default('processing');
            $table->unsignedInteger('videoable_id');
            $table->string('videoable_type');
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
        Schema::dropIfExists('videos');
    }
}
