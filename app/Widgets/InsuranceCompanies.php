<?php

namespace App\Widgets;

use App\Insurer;
use Arrilot\Widgets\AbstractWidget;

class InsuranceCompanies extends AbstractWidget
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
        $insurance = Insurer::where('isActive', 1)->orderBy('name', 'ASC')->get();
        return view('widgets.insurance_companies', [
            'config' => $this->config,
            'value' => $this->config['value'],
            'insurerArr' => $insurance
        ]);
    }
}
