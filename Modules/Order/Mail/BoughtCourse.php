<?php

namespace Modules\Order\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BoughtCourse extends Mailable
{
    use Queueable;
    use SerializesModels;
    private $courses;

    /**
     * BoughtCourse constructor.
     * @param $course
     */
    public function __construct($courses)
    {
        $this->courses = $courses;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('order::emails.bought-course')->with(['courses' => $this->courses]);
    }
}
