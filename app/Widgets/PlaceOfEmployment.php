<?php

namespace App\Widgets;
use App\CountryListModel;
use App\State;
use Arrilot\Widgets\AbstractWidget;

class PlaceOfEmployment extends AbstractWidget
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
        $emirates = State::all();
        return view('widgets.place_of_employment', [
            'config' => $this->config['data'],
            'value' => $this->config['value'],
            'country_name' => $country_name,
            'emirates' => $emirates
        ]);
    }
}
