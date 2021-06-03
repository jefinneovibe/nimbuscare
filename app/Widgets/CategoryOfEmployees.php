<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

class CategoryOfEmployees extends AbstractWidget
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

        return view('widgets.category_of_employees', [
            'config' => $this->config['data'],
            'value' => $this->config['value']
        ]);
    }
}
