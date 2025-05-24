<?php

use Modules\Course\Entities\Note;
use Modules\User\Entities\User;
use Modules\Order\Entities\Order;
use Modules\Course\Entities\Course;
use Modules\Trainer\Entities\Trainer;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoteOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('note_order', function (Blueprint $table) {
            $table->id();
            $table->decimal('total', 9, 3);
            $table->foreignIdFor(Note::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(Order::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('trainer_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('note_order');
    }
}
