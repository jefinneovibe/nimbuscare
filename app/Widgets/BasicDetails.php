<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use App\WorkTypeData;
use stdClass;
use MongoDB\BSON\ObjectID;

class BasicDetails extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $workTypeId = $this->config['workTypeId'];
        $stage =  $this->config['stage'];
        $step =  $this->config['step'];
        $CFValueKey =  @$this->config['CFValueKey'];
        $CFArrayKey =  @$this->config['CFArrayKey'];
        $formValues = $this->config['values'];
        $values = [];
        if ($formValues) {
            $values = @$formValues[$step]?:$formValues;
        }
        $findFieldTotal =  base64_encode(json_encode(@$this->config['findFieldTotal']));
        return view(
            'widgets.basic_details', [
            'workTypeId' => $this->config['workTypeId'],
            'workTypeDataId' => $this->config['workTypeDataId'],
            'stage' => $this->config['stage'],
            'step' => $this->config['step'],
            'findFieldTotal' => @$findFieldTotal,
            'formValues' => @$this->config['formValues'],
            'proceedToNextStage' => @$this->config['proceedToNextStage'],
            'config' => $this->config['data'],
            'cancelButton' => @$this->config['cancelButton'],
            'values' => $values,
            'CFValueKey' => $CFValueKey,
            'CFArrayKey' => $CFArrayKey,
            'filler_type' =>@$this->config['filler_type']
            ]
        );
    }
}
