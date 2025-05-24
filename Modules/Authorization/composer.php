<?php

use Modules\Authorization\ViewComposers\Dashboard\AdminRolesComposer;
use Modules\Authorization\ViewComposers\Dashboard\TrainerRolesComposer;

view()->composer([
    'user::dashboard.admins.index',
], AdminRolesComposer::class);
view()->composer([
    'trainer::dashboard.trainers.index',
], TrainerRolesComposer::class);
