<?php

namespace Modules\Order\Entities;

use Carbon\Carbon;
use Modules\Course\Entities\Note;
use Modules\User\Entities\User;
use Modules\Course\Entities\Course;
use Illuminate\Database\Eloquent\Model;

class NoteOrder extends Model
{
    protected $table = "note_order";
    protected $fillable = [
        'total',
        'note_id',
        'order_id',
        'trainer_id',
    ];

    public function note()
    {
        return $this->belongsTo(Note::class)->withTrashed();
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
