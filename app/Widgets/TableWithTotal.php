<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

class TableWithTotal extends AbstractWidget
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
            'widgets.table_with_total', [
            'config' => $this->config['data'],
            'values' => $this->config['value']
            ]
        );
    }
}
