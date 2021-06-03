<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

class WidgetGroup extends AbstractWidget
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

        return view('widgets.widget_group', [
            'config' => $this->config['data'],
            'value' => $this->config['value'],
            'workTypeId' => $this->config['workTypeId'],
        ]);
    }
}
