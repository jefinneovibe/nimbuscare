<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

class RadioWithTwoChildren extends AbstractWidget
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

        return view('widgets.radio_with_two_children', [
            'config' => $this->config,
            'formValues'=>$this->config['formValues'],
            'step' =>  $this->config['step'],
            'value' => $this->config['value'],
            'workTypeDataId' => $this->config['workTypeDataId']
        ]);
    }
}
