<?php

namespace Modules\Semester\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Route;
use Modules\Semester\Repositories\Frontend\SemesterRepository as Semester;

class SemesterController extends Controller
{
    public $semester;
    public function __construct(Semester $semester)
    {
        $this->semester    = $semester;
    }

    public function index()
    {
        $semesters = $this->semester->getAllSemesters();

        return view('semester::frontend.index', compact('semesters'));
    }

    public function mediaCenter()
    {
        $semesters = $this->semester->getAllMediaCenter();

        return view('semester::frontend.media_center', compact('semesters'));
    }

    public function show($slug)
    {
        $semester = $this->semester->findBySlug($slug);

        if (!checkRouteLocale($semester, $slug)) {
            return redirect()->route(Route::currentRouteName(), [$semester->slug]);
        }



        return view('semester::frontend.show', compact('semester'));
    }
}
