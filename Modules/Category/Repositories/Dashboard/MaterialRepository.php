<?php

namespace Modules\Category\Repositories\Dashboard;


use DB;
use Modules\Category\Entities\Material;
use Modules\Core\Repositories\Dashboard\CrudRepository;

class MaterialRepository extends CrudRepository
{

    public function __construct()
    {
        parent::__construct(Material::class);
    }

}
