<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Course\Entities\Course;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('review_questions', function (Blueprint $table) {
            $table->text('question');
            $table->foreignIdFor(Course::class)->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('review_questions', function (Blueprint $table) {
            $table->dropColumn(['course_id']);
        });
    }
};
