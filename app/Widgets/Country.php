<?php

namespace App\Widgets;

use App\CountryListModel;
use Arrilot\Widgets\AbstractWidget;

class Country extends AbstractWidget
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
        $country_name = [];
        $country_name_place = [];
        $all_countries = CountryListModel::get();
        foreach ($all_countries as $key => $country) {
            $name = $country['country'];
            $country_name[] = $name['countryName'];
        }
        // dd($country_name);
        return view('widgets.country', [
            'config' => $this->config['data'],
            'value' => $this->config['value'],
            'country_name' => $country_name
        ]);
    }
}
