<?php

namespace Modules\Course\Service;

use Modules\Course\Entities\CourseTarget;

class CourseTargetService
{
    public function createTargets($model, $targets)
    {
        $model->targets()->createMany($targets);
    }
    private function deleteManyTargets($deletedTargets)
    {
        CourseTarget::whereIn('id', $deletedTargets)->delete();
    }

    public function handelTargets($model, $request)
    {
        if ($request->deleted_targets) {
            $this->deleteManyTargets($request->deleted_targets);
        }
        if ($request->targets) {
            $this->createTargets($model, $request->targets);
        }

        if ($request->old_targets) {
            foreach ($request->old_targets as $key => $value) {
                $model->targets()->where('id', $value['id'])->first()->update($value);
            }
        }
    }
}
