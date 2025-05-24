<?php

namespace Modules\Exam\Repositories\Dashboard;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Modules\Exam\Entities\Question;
use Modules\Exam\Entities\QuestionAnswer;
use Modules\Core\Repositories\Dashboard\CrudRepository;

class QuestionRepository extends CrudRepository
{
    public function __construct()
    {
        parent::__construct(Question::class);
        $this->statusAttribute=[];
        $this->fileAttribute=['audio'=>'audio','image' => 'images'];
    }


    /**
    * Prepare Data before save or edir
    *
    * @param array $data
    * @param \Illuminate\Http\Request $request
    * @param boolean $is_create
    * @return array
    */
    public function prepareData(array $data, Request $request, $is_create = true): array
    {
        if ($request->with_file=='on') {
            $data['type']='audio';
        } else {
            $removeAudioFromRequest=Arr::pull($data, 'audio');
            $data['type']='question';
        }
        return parent::prepareData($data, $request, $is_create);
    }


    public function modelCreated($model, $request, $is_created = true): void
    {
        $this->createAnswers($model, $request->answers);
    }
    public function modelUpdated($model, $request): void
    {
        if ($request->deletedAnswers) {
            $this->deleteManyAnswers($request->deletedAnswers);
        }
        if ($request->answers) {
            $this->createAnswers($model, $request->answers);
        }
        if ($request->old_answers) {
            foreach ($request->old_answers as $key => $value) {
                $model->answers()->where('id', $value['id'])->first()->update($value);
            }
        }

        if ($model->type!='audio') {
            $model->clearMediaCollection('audio');
        }
    }


    private function createAnswers($model, $answers)
    {
        if($answers){
            $model->answers()->createMany($answers);
        }
    }
    private function deleteManyAnswers($deletedAnswers)
    {
        QuestionAnswer::whereIn('id', $deletedAnswers)->delete();
    }
}
