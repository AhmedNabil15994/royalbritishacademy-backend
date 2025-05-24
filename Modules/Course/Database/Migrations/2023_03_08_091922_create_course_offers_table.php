<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Course\Entities\Course;

class CreateCourseOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_offers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('start_at');
            $table->date('end_at');
            $table->boolean('status')->default(false);
            $table->decimal('offer_price', 9, 3)->nullable();
            $table->decimal('percentage', 9, 3)->nullable();
            $table->foreignIdFor(Course::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('course_offers');
    }
}
