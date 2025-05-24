<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->json("title");
            $table->json("description")->nullable();
            $table->boolean("status")->default(true);
            $table->decimal("price")->default(0);
            $table->unsignedInteger("duration")->default(1);
            $table->unsignedTinyInteger("sort")->default(2);
            $table->boolean("is_free")->default(false);
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
        Schema::dropIfExists('packages');
    }
}
