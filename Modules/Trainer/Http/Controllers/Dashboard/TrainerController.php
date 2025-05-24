<?php

namespace Modules\Trainer\Http\Controllers\Dashboard;

use Modules\User\Entities\User;
use Illuminate\Routing\Controller;

use Modules\Core\Traits\Dashboard\CrudDashboardController;

class TrainerController extends Controller
{
    use CrudDashboardController {
        CrudDashboardController::__construct as private __crudConstruct;
}

    public function __construct()
    {
        $this->__crudConstruct();
        $this->model=new User();
    }
}
