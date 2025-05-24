<?php

namespace Modules\Trainer\ViewComposers\Frontend;

use Modules\Trainer\Repositories\Frontend\TrainerRepository as Trainer;
use Illuminate\View\View;
use Cache;

class TrainerComposer
{
    public $trainers = [];

    public function __construct(Trainer $trainer)
    {
        $this->trainers =  $trainer->getRandomTrainers();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('trainers', $this->trainers);
    }
}
