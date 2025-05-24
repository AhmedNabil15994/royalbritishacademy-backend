<?php

namespace Modules\Course\Repositories\Frontend;

use Illuminate\Support\Facades\DB;
use Modules\Course\Entities\Course;
use Modules\Course\Entities\UserVideo;
use Modules\Course\Entities\LessonContent;

class UserVideoRepository
{
    public function create($request)
    {
        $lessonContent=LessonContent::with('video')->find($request->lesson_content_id);

        $videoCompleteWatched=$this->userCompleteWatched($lessonContent, $request->totalPlayed);
        $this->checkUserFinishCourse($lessonContent);
        $userVideo=UserVideo::updateOrCreate(
            ['lesson_content_id'=>$lessonContent->id,
             'user_id'  =>  auth()->id()
            ],
            [
                'lesson_content_id'=>$lessonContent->id,
                'user_id'          =>auth()->id(),
                'totalPlayed'      =>DB::raw("totalPlayed + " . (int)$request->totalPlayed),
                'watched'          =>$videoCompleteWatched,
            ]
        );
        return response()->json($userVideo);
    }
    public function checkUserHaveSeenThisBefore($lessonContent)
    {
        return auth()->user()->userVideos()->where('lesson_content_id', $lessonContent->id)->first();
    }

    public function userCompleteWatched($lessonContent, $totalPlayed)
    {
        $userHaveSeenThisBefore=$this->checkUserHaveSeenThisBefore($lessonContent);

        if ($userHaveSeenThisBefore) {
            return  $lessonContent->video->video_length<=$totalPlayed+$userHaveSeenThisBefore->totalPlayed;
        }
        return    $lessonContent->video->video_length<=$totalPlayed;
    }

    public function checkUserFinishCourse($lessonContent)
    {
        $course=Course::withCount([
            'orderCourse',
            'lessons',
            'lessonContents'=>fn ($q) =>$q->whereType('video'),
            ])
            ->where('id', $lessonContent->lesson->course_id)
            ->firstOrFail();
        $userFinishedVideosCount=UserVideo::whereWatched(1)
                                    ->whereLessonContentId($lessonContent->id)
                                    ->count();

        if ($course->lesson_contents_count==$userFinishedVideosCount) {
            $userCoursesCount=auth()->user()
                              ->orderCourses()
                              ->where('course_id', $course->id)
                              ->first()
                              ->update(['is_watched'=>1]);
        }
    }
}
