<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

class SelectWithChildren extends AbstractWidget
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
            'widgets.select_with_children', [
            'config' => $this->config['data'],
            'value' => $this->config['value'],
            'workTypeDataId' => @$this->config['workTypeDataId'],
            'formValues' => @$this->config['formValues']
            ]
        );
    }
}
