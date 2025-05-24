<?php

use Modules\Exam\Entities\Exam;
use Modules\Course\Entities\Video;
use Modules\Course\Entities\Lesson;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson_contents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedInteger('order');
            $table->string('type');
            $table->foreignIdFor(\Modules\Course\Entities\Course::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();

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
        Schema::dropIfExists('lesson_contents');
    }
}
