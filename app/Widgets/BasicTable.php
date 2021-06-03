<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

class BasicTable extends AbstractWidget
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
        // dd($this->config['data']);
        return view(
            'widgets.basic_table', [
            'config' => $this->config['data'],
            'value' => $this->config['value']
            ]
        );
    }
}
