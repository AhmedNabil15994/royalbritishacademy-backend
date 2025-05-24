<?php

use Illuminate\Support\Facades\DB;
use Modules\Trainer\Entities\Trainer;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->decimal('price', 9, 3);
            $table->json('short_desc');
            $table->json('description');
            $table->json('requirements')->nullable();
            $table->json('slug')->nullable();
            $table->boolean('is_certificated')->default(false);
            $table->boolean('status')->default(false);
            $table->string('image')->nullable();
            $table->string('class_time')->nullable();
            $table->integer('period')->nullable();
            $table
                ->foreignIdFor(Trainer::class)
                ->nullable()
                ->constrained('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->schemalessAttributes('extra_attributes');
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
        Schema::dropIfExists('courses');
    }
}
