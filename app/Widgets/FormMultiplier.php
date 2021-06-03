<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

class FormMultiplier extends AbstractWidget
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
        //
        return view(
            'widgets.form_multiplier', [
            'config' => $this->config['data'],
            'value' => $this->config['value'],
            'formValues' => $this->config['formValues'],
            'step'=>$this->config['step'],
            'workTypeId'=>$this->config['workTypeDataId']
            ]
        );
    }
}
