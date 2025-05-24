<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Course\Entities\CourseReview;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('review_question_answers', function (Blueprint $table) {
            $table->text('answer')->change();
            $table->unsignedBigInteger('course_review_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('review_question_answers', function (Blueprint $table) {
            $table->dropColumn(['answer']);
            
        });
    }
};
