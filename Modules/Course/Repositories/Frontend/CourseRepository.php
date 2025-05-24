<?php

namespace Modules\Course\Repositories\Frontend;

use Carbon\Carbon;
use Modules\Course\Entities\Course;

class CourseRepository
{
    public function __construct()
    {
        $this->course = new Course;
    }

    public function getByCategoriesIds($ids, $order = 'id', $sort = 'desc')
    {
        $courses = $this->course->active()->whereHas('categories', function ($query) use ($ids) {
            $query->whereIn('categories.id', $ids);
        })->orderBy($order, $sort)->paginate(24);

        return $courses;
    }

    public function getRelatedCourses($ids, $order = 'id', $sort = 'desc')
    {
        $courses = $this->course->active()->whereHas('categories', function ($query) use ($ids) {
            $query->whereIn('categories.id', (array)$ids);
        });

        return $courses;
    }

    public function getCourses($request,$isLatest = false ,$order = 'id', $sort = 'desc')
    {
        $courses = $this->course->active()->withCount(['subscriptions','lessons'])->where(function($q) use($request,$isLatest){

            if($request->category_id){
                $q->whereHas('categories', function ($query) use ($request) {
                    $query->where('categories.id', $request->category_id);
                });
            }

            if($request->search){
                $q->where(function ($query) use ($request) {
                    foreach (config('translatable.locales') as $code) {
                        $query->orWhere('title->' . $code, 'like', '%' . $request->input('search') . '%');
                        $query->orWhere('slug->' . $code, 'like', '%' . $request->input('search') . '%');
                    }
                });
            }

            if($request->material_id){
                $q->whereHas('materials', function ($query) use ($request) {
                    $query->where('materials.id', $request->material_id);
                });
            }

            if($isLatest || ($request->type && $request->type == 'is_latest')){

                $q->where('is_latest', true);
            }

        })->orderBy(\DB::raw('ISNULL('.$order.'),'.$order.''), $sort);

        return $courses;
    }



    public function getEventsByCategoriesIds($ids, $order = 'id', $sort = 'desc')
    {
        $courses = $this->course->active()->where('is_online', false)->whereHas('categories', function ($query) use ($ids) {
            $query->whereIn('categories.id', $ids);
        })->orderBy($order, $sort)->paginate(24);

        return $courses;
    }

    public function getCoursesByCategoriesIds($ids, $order = 'id', $sort = 'desc')
    {
        $courses = $this->course->active()->where('is_online', true)->whereHas('categories', function ($query) use ($ids) {
            $query->whereIn('categories.id', $ids);
        })->orderBy($order, $sort)->get();

        return $courses;
    }

    public function getLimitedEvents($order = 'id', $sort = 'desc')
    {
        $events = $this->course->active()->where('is_online', false)->orderBy($order, $sort)->paginate(24);
        return $events;
    }

    public function getLimitedCourses($order = 'id', $sort = 'desc')
    {
        $courses = $this->course->active()->orderBy($order, $sort)->take(24)->get();
        return $courses;
    }

    public function getAllEvents($order = 'id', $sort = 'desc')
    {
        $events = $this->course->active()->where('is_online', false)->orderBy($order, $sort)->paginate(24);
        return $events;
    }

    public function getAllCourses($request, $order = 'id', $sort = 'desc')
    {


        $courses = $this->course
            ->when(auth()->check(), fn ($q) => $q->subscribed(auth()->id()))
            ->where(function ($query) use ($request) {
                if ($request->category_id) {
                    $query->whereHas('categories', function ($query) use ($request) {
                        $query->where('category_id', $request->category_id);
                    });
                }
            });
        return $courses->orderBy($order, $sort)->get();
    }


    public function getCoursesByCategory()
    {


        $range = [];
        return  $this->course->active()->orderBy('order','asc')
            ->when(auth()->check(), fn ($q) => $q->subscribed(auth()->id()))
            ->when(request('categories'), fn ($q) => $q->categories(request('categories')))
            ->when(request('category_id'), fn ($q) => $q->categories((array)request('category_id')))
            ->when(request('s'), fn ($q, $val) => $q->search($val))
            ->when(
                request('price_from') && request('price_to'),
                fn ($q) => $q->whereBetween('price',  [request('price_from'), request('price_to')]),
            )->when(
                request('genders'),
                function ($q) {
                    $q->whereJsonContains('extra_attributes->gender', request('genders'));
                }
            );
    }


    public function subscribedCourses($order = 'id', $sort = 'desc')
    {
        return $this->course
            ->when(auth()->check(), fn ($q) => $q->subscribed(auth()->id()))
            ->withCount('orderCourse')
            ->whereHas(
                'orderCourse',
                fn ($q) => $q
                    ->whereUserId(auth()->id())
                    ->notExpired()
                    ->successPay()
            )->orderBy($order, $sort)->get();
    }

    public function subscribedLiveCourses($order = 'id', $sort = 'desc')
    {
        return $this->course->active()->where('is_live', 1)->withCount('orderCourse')->whereHas('orderCourse.order', function ($query) {
            $query->whereHas('orderStatus', function ($query) {
                $query->successPayment();
            })->where('user_id', auth()->id());
        })->orderBy($order, $sort)->get();
    }

    public function findEventBySlug($slug)
    {
        return $this->course->active()->where('slug->' . locale(), $slug)->first();
    }

    public function findCourseBySlug($slug)
    {
        return $this->course
            ->when(auth()->check(), fn ($q) => $q->subscribed(auth()->id()))
            ->withCount('orderCourse', 'lessons')
            ->anyTranslation('slug', $slug)
            ->with('lessons.lessonContents.media', 'lessons.lessonContents.video', 'video', 'targets', 'activeCourseReviews', 'trainer')
            ->firstOrFail();
    }

    public function findCourseById($id)
    {
        return $this->course->active()
            ->withCount('orderCourse', 'lessons')
            ->with(
                'lessons.media',
                'lessons.video',
                'video',
                'targets',
                'activeCourseReviews',
                'trainer'
            )->with(['lessons'=> function($withQuery){
               $withQuery->orderBy('order','asc');
            }])->find($id);
            // ->findOrFail($id);
    }


    public function getCalenderCourses($order = 'id', $sort = 'desc')
    {
        return $this->course->active()->where('is_live', 1)
            ->withCount('orderCourse')
            ->whereHas('orderCourse.order', function ($query) {
                $query->whereHas('orderStatus', function ($query) {
                    $query->successPayment();
                })->where('user_id', auth()->id());
            })
            ->orWhere('trainer_id', auth()->id())
            ->where('is_live', 1)
            ->orderBy($order, $sort)->get();
    }




    public function autoCompleteSearch($request)
    {
        return $this->course->active()->active()->where(function ($query) use ($request) {
            $query->where(function ($query) use ($request) {
                foreach (config('translatable.locales') as $code) {
                    $query->orWhere('title->' . $code, 'like', '%' . $request->input('query') . '%');
                    $query->orWhere('slug->' . $code, 'like', '%' . $request->input('query') . '%');
                }
            });
        });
    }
}
