<?php

use Modules\Exam\Entities\Question;
use Modules\Exam\Entities\UserExam;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Modules\Exam\Entities\QuestionAnswer;
use Illuminate\Database\Migrations\Migration;

class CreateUserExamAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_exam_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(UserExam::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(QuestionAnswer::class)->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('degree')->nullable();
            $table->foreignIdFor(Question::class)
                ->constrained()
                ->cascadeOnDelete();
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
        Schema::dropIfExists('user_exam_answers');
    }
}
