<?php

namespace App\Widgets;
use App\State;

use Arrilot\Widgets\AbstractWidget;

class Emirate extends AbstractWidget
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
        $emirates = [];
        $emirates = State::all();
        return view('widgets.emirate', [
            'config' => $this->config['data'],
            'value' => $this->config['value'],
            'emirates' => $emirates
        ]);
    }
}
