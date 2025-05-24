<?php

use Modules\Exam\Entities\Exam;
use Modules\User\Entities\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_exams', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(Exam::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('questions_count')->default(0);
            $table->integer('correct_answers_count')->default(0);
            $table->integer('exam_result')->default(0);
            $table->integer('exam_degree')->default(0);
            $table->integer('success_degree')->default(0);
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
        Schema::dropIfExists('user_exams');
    }
}
