<?php

namespace Modules\Course\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CoursePeriodEmail extends Mailable
{
    use Queueable;
    use SerializesModels;
    private $title;
    private $dif_in_days;

    /**
     * CoursePeriodEmail constructor.
     * @param $course
     * @param $dif_in_days
     */
    public function __construct($course, $dif_in_days)
    {
        $this->title = $course->translate(locale())->title;
        $this->dif_in_days = $dif_in_days;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('course::emails.course-period-expiring')->with([
            'url' => url('/'),
            'title' => $this->title,
            'dif_in_days' => $this->dif_in_days,
            ]);
    }
}
