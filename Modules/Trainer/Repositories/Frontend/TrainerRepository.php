<?php

namespace Modules\Trainer\Repositories\Frontend;

use Modules\Trainer\Entities\Trainer;
use Hash;
use DB;

class TrainerRepository
{
    public function __construct(Trainer $trainer)
    {
        $this->trainer      = $trainer;
    }

    public function getRandomTrainers($order = 'id', $sort = 'desc')
    {
        $trainers = $this->trainer->whereHas('roles.permissions', function ($query) {
            $query->where('name', 'trainer_access');
        })->inRandomOrder()->take(15)->get();
        return $trainers;
    }

    public function getAllActive($order = 'id', $sort = 'desc')
    {
        $trainers = $this->trainer->whereHas('roles.permissions', function ($query) {
            $query->where('name', 'trainer_access');
        })->inRandomOrder()->get();

        return $trainers;
    }

    public function findById($id)
    {
        $trainer = $this->trainer->find($id);

        return $trainer;
    }
}
