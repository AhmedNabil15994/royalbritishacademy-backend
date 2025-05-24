<?php

namespace Modules\Trainer\ViewComposers\Dashboard;

use Modules\Trainer\Repositories\Dashboard\TrainerRepository as Trainer;
use Illuminate\View\View;
use Cache;

class TrainerComposer
{
    public $trainers = [];

    public function __construct(Trainer $trainer)
    {
        $this->trainers =  $trainer->getAll();
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
