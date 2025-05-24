<?php

namespace Modules\User\ViewComposers\Dashboard;

use Modules\User\Repositories\Dashboard\UserRepository as User;
use Illuminate\View\View;
use Cache;

class UserComposer
{
    public $users = [];

    public function __construct(User $user)
    {
        $this->users =  $user->getAll();
    }

    public function compose(View $view)
    {
        $view->with('users' , $this->users);
    }
}
