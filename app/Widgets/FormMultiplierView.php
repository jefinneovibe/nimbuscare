<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use App\WorkTypeData;
use App\WorkTypeForms;
use MongoDB\BSON\ObjectID;

class FormMultiplierView extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];
    public function placeholder()
    {
        return 'Loading...';
    }


    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        //
        $workTypeDataId = $this->config['workTypeId'];
        $workTypeData = WorkTypeData::where('_id', new ObjectId($workTypeDataId))->first();
        $worktypeForm =WorkTypeForms::where('worktypeId', $workTypeData['workTypeId']['id'])->first();
        $valueKey =  @$this->config['data']['valueKey'];
        $count = count(@$workTypeData->eQuestionnaire[$valueKey]);
        $ldetails = @$workTypeData->eQuestionnaire[@$valueKey];
        $DetailJson = @$worktypeForm['stages']['eQuestionnaire']['steps'][$valueKey]['rows'];
        return view(
            'widgets.form_multiplier_view', [
            'config' => $this->config['data'],
            'valueKey' => @$valueKey,
            'count' => $count?:0,
            'ldetails' => $ldetails?:[],
            'workTypeDataId'=>@$workTypeDataId,
            'DetailJson'=>@$DetailJson
            ]
        );
    }
}
