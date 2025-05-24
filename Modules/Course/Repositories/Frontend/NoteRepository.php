<?php

namespace Modules\Course\Repositories\Frontend;

use Carbon\Carbon;
use Modules\Course\Entities\Note;

class NoteRepository
{
    private $note;

    public function __construct(Note $note)
    {
        $this->note = $note;
    }

    public function findNoteById($id)
    {
        return $this->note
            ->active()
            ->find($id);
            // ->findOrFail($id);
    }
}
