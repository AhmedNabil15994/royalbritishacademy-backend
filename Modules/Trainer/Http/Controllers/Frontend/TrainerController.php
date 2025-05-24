<?php

namespace Modules\Trainer\Http\Controllers\Frontend;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Area\Entities\Country;
use Modules\Trainer\Entities\Apply;
use Modules\Trainer\Entities\Trainer;
use Illuminate\Support\Facades\Notification;
use Modules\Trainer\Notifications\TrainerApplyNotification;
use Modules\Trainer\Repositories\Frontend\TrainerRepository ;
use Modules\Trainer\Http\Requests\Frontend\InstructorApplyRequest;

class TrainerController extends Controller
{
    public function __construct(TrainerRepository  $trainer)
    {
        $this->trainer    = $trainer;
    }

    public function index()
    {
        $trainers = $this->trainer->getAllActive();

        return view('trainer::frontend.index', compact('trainers'));
    }

    public function show($id)
    {
        $trainer =Trainer::where('id', $id)->withCount('courseReviews')->first();
        if (!$trainer) {
            abort(404);
        }
        return view('trainer::frontend.show', compact('trainer'));
    }
    public function instructorApply()
    {
        $countries = $this->countries();
        return view('trainer::frontend.instructor-apply', compact('countries'));
    }


    public function sendInstructorApply(InstructorApplyRequest $request)
    {
        $validated=$request->validated();
        $cv=Arr::pull($validated, 'cv');
        $apply= Apply::create($validated);
        $apply->addMedia($cv)->toMediaCollection('cv');
        Notification::route('mail', setting('contact_us', 'email'))
           ->notify((new TrainerApplyNotification($request))->locale(locale()));
        return response()->json([true , __('You\'r Apply request sent and we will check it soon ')]);
    }




    public function countries()
    {
        $countries=Country::pluck('title', 'id');
        return $countries;
    }
}
