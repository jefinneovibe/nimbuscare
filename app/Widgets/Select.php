<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

class Select extends AbstractWidget
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
        if (isset($this->config['data']['generateOption']) && $this->config['data']['generateOption']== true) {
            $this->config['data'] = $this->generateOption($this->config['data']);
        }

        return view(
            'widgets.select', [
            'config' => $this->config['data'],
            'value' => $this->config['value']
            ]
        );
    }

    private function generateOption($data)
    {
        $optionFor = $data['optionFor'];
        switch ($optionFor) {
        case 'date':
            return $this->generateDate($data);
                break;
        case 'number':
            return $this->generateNumber($data);
                break;
        default:
            return $data;
        }
    }

    private function generateDate($data)
    {
        $date = date("Y");
        $options = [];
        $key = @$data['id']?:'date_';
        $min = @$data['min']?:$date;
        $max = @$data['max']?:$date;
        for ($year = $min; $year <= $max; $year++) {
            $option = [];
            $option['option_id'] = $key.'_'.$year;
            $option['option_value'] = $year;
            $options[] = $option;
        }
        $data['options'] = array_reverse($options);
        return $data;
    }

    private function generateNumber($data)
    {
        $options = [];
        $key = @$data['id']?:'date_';
        $min = @$data['min']?:0;
        $max = @$data['max']?:100;
        for ($num = $min; $num <= $max; $num++) {
            $option = [];
            $option['option_id'] = $key.'_'.$num;
            $option['option_value'] = $num;
            $options[] = $option;
        }
        $data['options'] = $options;
        return $data;
    }
}
