<?php

namespace Modules\Cart\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Cart\Traits\CartTrait;
use Modules\Cart\Http\Requests\Frontend\CartRequest;
use Modules\Course\Transformers\Frontend\CourseResource;
use Modules\Course\Transformers\Frontend\NoteResource;
use Modules\Package\Transformers\Frontend\CartPackageResource;
use Modules\Course\Repositories\Frontend\CourseRepository as Course;
use Modules\Course\Repositories\Frontend\NoteRepository as Note;
use Modules\Package\Repositories\Frontend\PackageRepository as Package;

class CartController extends Controller
{
    use CartTrait;

    protected $course;
    protected $note;
    protected $package;

    public function __construct(Course $course,Note $note,Package $package)
    {
        $this->course = $course;
        $this->note = $note;
        $this->package = $package;
    }

    public function index(Request $request)
    {
        $coursesSubscribed = $this->course->subscribedCourses();
        foreach ($coursesSubscribed as $course) {
            $this->removeItem($course['id'], 'course');
        }
        $items = $this->getCartContent();

        return view('cart::frontend.show', compact('items'));
    }

    public function add(CartRequest $request, $type, $id)
    {
        $item = $this->getItem($id, $type);
        if (is_null($item)) {
            return redirect()->route('frontend.cart.index')->with([
                'msg'     => 'course not found',
                'alert'   => 'danger',
                'courses' => null,
            ]);
        }
        $this->addToCart($item, $type, $request->qty);
        $item = $this->getCartContent();
        return redirect()->route('frontend.cart.index')->with([
            'msg'     => __('cart::frontend.message.add_to_cart'),
            'alert'   => 'success',
            'courses' => $item,
        ]);
    }
    private function  getItem($id, $type)
    {
        try {
            switch($type){
                case 'note':
                    $model = $this->note->findNoteById($id);
                    $item = !is_null($model) ? (new NoteResource($model))->jsonSerialize() : null;
                    break;
                case 'course':
                    $model = $this->course->findCourseById($id);
                    $item = !is_null($model) ? (new CourseResource($model))->jsonSerialize() : null;
                    break;
                case 'package':
                    $model = $this->package->findPackageById($id);
                    $item = !is_null($model) ? (new CartPackageResource($model))->jsonSerialize() : null;
                    break;
            }

            return $item;
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }
    public function remove($type, $id)
    {
        $this->removeItem($id, $type);

        $item = $this->getCartContent();

        return redirect()->route('frontend.cart.index')->with([
            'msg' => __('cart::frontend.message.remove_from_cart'),
            'alert' => 'success',
            'courses' => $item,
        ]);
    }

    public function clear()
    {
        $this->clearCart();

        $items = $this->getCartContent();

        return redirect()->route('frontend.cart.index')->with([
            'message' => __('cart::frontend.message.clear_cart'),
            'alert' => 'success',
            'courses' => $items,
        ]);
    }
}
