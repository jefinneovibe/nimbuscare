<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

class RadioWithChildren extends AbstractWidget
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
        // dd($this->config);

        return view('widgets.radio_with_children', [
            'config' => $this->config,
            'value' => $this->config['value']        
        ]);
    }
}
