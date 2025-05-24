<?php

namespace Modules\Package\Repositories\Frontend;

use Modules\Core\Repositories\Dashboard\CrudRepository;
use Modules\Package\Entities\Package as Model;
use Modules\Package\Entities\Package;
use Modules\Package\Entities\PackagePrice;

class PackageRepository extends CrudRepository
{
    public function getModel()
    {
        $this->model = new Package;

        return $this->model;
    }

    public function getAllPackages()
    {
        return  $this->getModel()->latest()->active()
            ->when(request('categories'), fn ($q) => $q->categories(request('categories')))
            ->when(request('category_id'), fn ($q) => $q->categories((array)request('category_id')))
            ->when(request('s'), fn ($q, $val) => $q->search($val))
            ->when(
                request('price_from') && request('price_to'),
                fn ($q) => $q->whereBetween('price',  [request('price_from'), request('price_to')]),
            );
    }

    public function findPackageById($id)
    {
        return PackagePrice::whereHas('package', function ($query) {
            $query->active();
        })
        ->find($id);
        // ->findOrFail($id);
    }
}
