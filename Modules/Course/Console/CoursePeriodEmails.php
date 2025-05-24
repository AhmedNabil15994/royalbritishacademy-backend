<?php

namespace Modules\Course\Console;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Modules\Course\Mail\CoursePeriodEmail;
use Modules\Order\Entities\OrderCourse;

class CoursePeriodEmails extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'course:period-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this command for check the courses almost expired to notify users by sending email ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $order_courses = OrderCourse::where(function ($q) {
            $q->whereNotNull('expired_date')
                ->where('expired_date', '>=', Carbon::now()->toDateTimeString())
                ->where('expired_date', '<=', Carbon::now()->addDays(5)->toDateTimeString());
        })->whereHas('order', function ($query) {
            $query->whereHas('orderStatus', function ($query) {
                $query->successPayment();
            });
        })->get();

        foreach ($order_courses as $course):
            $days_count = Carbon::now()->diffInDays(Carbon::parse($course->expired_date)->toDateTimeString());
        Mail::to(optional(optional($course->order)->user)->email)->send(new CoursePeriodEmail($course->course, $days_count));
        endforeach;
    }
}
