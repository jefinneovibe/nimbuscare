<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

class EslipWidget extends AbstractWidget
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
        $valueArr = $this->config['values'];
        $formValues = $this->config['formValues'];
        $values = [];
        if ($valueArr) {
            $values = @$valueArr[$step]?:[];
        }
        $reviewArr =  $this->config['reviewArr'];
        $postvalue = base64_encode(json_encode($reviewArr)); 
        return view('widgets.eslip_widget', [
            'workTypeId' => $this->config['workTypeId'],
            'workTypeDataId' => $this->config['workTypeDataId'],
            'stage' => $this->config['stage'],
            'step' => $this->config['step'],
            'config' => $this->config['data'],
            'values' => $values,
            'formValues' => $formValues,
            'reviewArr' => $postvalue,
            'company_id' => $this->config['company_id'],
            'insurer_list' => $this->config['insurer_list'],
            'documents' => $this->config['documents'],
        ]);
    }
}
