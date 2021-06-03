<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

class ClaimHistoryMultipleView extends AbstractWidget
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

        return view('widgets.claim_history_multiple_view', [
            'config' => $this->config['data'],
            'formValues' => $this->config['formValues']
        ]);
    }
}
