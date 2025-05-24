<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Course\Entities\CourseReview;
use Modules\Course\Entities\ReviewQuestion;

class CreateReviewQuestionAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review_question_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(CourseReview::class)->constrained();
            $table->foreignIdFor(ReviewQuestion::class)->constrained();
            $table->boolean('answer');
            $table->boolean('status')->default(1);
            $table->softDeletes();
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
        Schema::dropIfExists('review_question_answers');
    }
}
