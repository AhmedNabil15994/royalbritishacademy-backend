<?php

use Modules\Area\Entities\Country;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Area\Entities\City;

class AddChangeRelationAppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applies', function (Blueprint $table) {
            $table->dropConstrainedForeignId('city_id');
            $table->foreignIdFor(Country::class)->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('applies', function (Blueprint $table) {
            $table->dropConstrainedForeignId('country_id');
            $table->foreignIdFor(City::class)->constrained()->cascadeOnDelete();
        });
    }
}
